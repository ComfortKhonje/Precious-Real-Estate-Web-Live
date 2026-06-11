<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\MediaService;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    protected array $defaultTitles = [
        'Property Valuation',
        'Property Management',
        'Property Development',
        'Property Sales & Letting',
        'Title Deed Processing',
    ];

    public function index()
    {

        $services = Service::orderBy('title')->get();

        return view('cms.services.index', compact('services'));
    }

    public function create()
    {
        return view('cms.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:services',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'icon' => 'nullable|string|max:255',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');

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

        return view('cms.services.edit', compact('service'));
    }

    public function update(Request $request, string $slug)
    {
        $title = str($slug)->replace('-', ' ')->title();
        $service = Service::where('title', $title)->firstOrFail();

        $data = $request->validate([
            'title' => 'required|string|max:255|unique:services,title,'.$service->id,
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'icon' => 'nullable|string|max:255',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');

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

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('cms.services.index')->with('status', 'Service deleted successfully.');
    }
}
