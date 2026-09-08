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
        $title = str($slug)->replace('-', ' ')->title();
        $service = Service::where('title', $title)->firstOrFail();
        $icons = ServiceIcon::orderBy('name')->get();

        return view('cms.services.edit', compact('service', 'icons'));
    }

    public function update(Request $request, string $slug)
    {
        $title = str($slug)->replace('-', ' ')->title();
        $service = Service::where('title', $title)->firstOrFail();

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
