<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceIcon;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    public function index()
    {

        $services = Service::with('serviceIcon')->orderBy('title')->get();

        return view('cms.services.index', compact('services'));
    }

    public function create()
    {
        $icons = ServiceIcon::orderBy('name')->get();

        return view('cms.services.create', compact('icons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:services',
            'tagline' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'features' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'service_icon_id' => 'nullable|exists:service_icons,id',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');
        $data['service_icon_id'] = $data['service_icon_id'] ?? null;
        $data['features'] = $this->featuresFromInput($request);

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = app(MediaService::class)->upload($request->file('banner_image'), 'services/banners');
        } else {
            unset($data['banner_image']);
        }

        Service::create($data);

        return redirect()->route('cms.services.index')->with('status', 'Service created successfully.');
    }

    public function edit(string $slug)
    {
        $service = $this->findBySlug($slug);
        $icons = ServiceIcon::orderBy('name')->get();

        return view('cms.services.edit', compact('service', 'icons'));
    }

    public function update(Request $request, string $slug)
    {
        $service = $this->findBySlug($slug);

        $data = $request->validate([
            'title' => 'required|string|max:255|unique:services,title,' . $service->id,
            'tagline' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'features' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'service_icon_id' => 'nullable|exists:service_icons,id',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');
        $data['service_icon_id'] = $data['service_icon_id'] ?? null;
        $data['features'] = $this->featuresFromInput($request);

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = app(MediaService::class)->replace(
                $request->file('banner_image'),
                'services/banners',
                $service->banner_image
            );
        } else {
            unset($data['banner_image']);
        }

        $service->update($data);

        return redirect()->route('cms.services.index')->with('status', 'Service updated successfully.');
    }

    /**
     * The route param is a slug (e.g. cms.services.edit links built from
     * str($service->title)->slug()), but services have no dedicated slug
     * column — this used to reverse it back into a title
     * (str($slug)->replace('-', ' ')->title()) and look that up, which only
     * round-trips correctly for a title that's already simple Title Case
     * ASCII words. Any title with punctuation, an acronym, or anything
     * slug() actually had to strip would silently 404 on its own edit
     * link. Matching forward (slug every real title, compare to the param)
     * is the same transform the link was built with, so it can't drift.
     */
    private function findBySlug(string $slug): Service
    {
        $service = Service::all()->first(fn (Service $s) => str($s->title)->slug()->value() === $slug);

        abort_if(! $service, 404);

        return $service;
    }

    /**
     * Same comma-separated-string convention as PropertiesController's
     * `features` field.
     */
    private function featuresFromInput(Request $request): array
    {
        return collect(explode(',', $request->input('features', '')))
            ->map(fn ($feature) => trim($feature))
            ->filter()
            ->values()
            ->all();
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('cms.services.index')->with('status', 'Service deleted successfully.');
    }
}
