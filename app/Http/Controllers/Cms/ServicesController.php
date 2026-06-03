<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
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
            'title' => 'required|string|max:255|unique:services,title',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'banner_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:255',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');

        if ($request->hasFile('banner_image_file')) {
            $path = $request->file('banner_image_file')->store('services/banners', 'public');
            $data['banner_image'] = 'storage/' . $path;
        }

        Service::create($data);

        return redirect()->route('cms.services.index')->with('status', 'Service created.');
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
            'title' => 'required|string|max:255|unique:services,title,' . $service->id,
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'banner_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_banner_image' => 'nullable|boolean',
            'icon' => 'nullable|string|max:255',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');

        if ($request->hasFile('banner_image_file')) {
            $this->deleteBannerImage($service);
            $path = $request->file('banner_image_file')->store('services/banners', 'public');
            $data['banner_image'] = 'storage/' . $path;
        } elseif ($request->boolean('remove_banner_image')) {
            $this->deleteBannerImage($service);
            $data['banner_image'] = '';
        }

        $service->update($data);

        return redirect()->route('cms.services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $this->deleteBannerImage($service);
        $service->delete();

        return redirect()->route('cms.services.index')->with('status', 'Service deleted.');
    }

    protected function deleteBannerImage(Service $service): void
    {
        if ($service->banner_image && str_starts_with($service->banner_image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $service->banner_image));
        }
    }
}
