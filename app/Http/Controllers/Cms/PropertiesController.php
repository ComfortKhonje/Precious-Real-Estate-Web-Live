<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Services\MediaService;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->get('search');
            $query->where('title', 'like', "%{$s}%")->orWhere('location', 'like', "%{$s}%");
        }

        $properties = $query->paginate(20);

        return view('cms.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('cms.properties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'type' => 'nullable|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string',
            'status' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'land_size' => 'nullable|string',
            'parking' => 'nullable|string',
            'features' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'media' => 'nullable|string',
        ]);

        $mediaJson = $data['media'] ?? null;
        unset($data['media']);

        $data['features'] = collect(
            explode(',', $request->input('features', ''))
        )
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
        $property = Property::create($data);

        if ($mediaJson) {
            $mediaPaths = json_decode($mediaJson, true);
            if (is_array($mediaPaths)) {
                foreach ($mediaPaths as $index => $path) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image_path' => $path,
                        'is_featured' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('cms.properties.index')->with('status', 'Property created.');
    }

    public function edit(Property $property)
    {
        return view('cms.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'type' => 'nullable|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string',
            'status' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'land_size' => 'nullable|string',
            'parking' => 'nullable|string',
            'features' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'media' => 'nullable|string',
        ]);

        $mediaJson = $data['media'] ?? null;
        unset($data['media']);

        $data['features'] = $data['features'] ? array_map('trim', explode(',', $data['features'])) : [];

        $property->update($data);

        $mediaPaths = $mediaJson ? json_decode($mediaJson, true) : [];
        if (! is_array($mediaPaths)) {
            $mediaPaths = [];
        }

        // Delete removed images (this triggers observer to delete physical files)
        $property->images()->whereNotIn('image_path', $mediaPaths)->get()->each->delete();

        // Sync remaining and new images
        foreach ($mediaPaths as $index => $path) {
            PropertyImage::updateOrCreate(
                ['property_id' => $property->id, 'image_path' => $path],
                ['is_featured' => $index === 0, 'sort_order' => $index]
            );
        }

        return redirect()->route('cms.properties.index')->with('status', 'Property updated.');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('cms.properties.index')->with('status', 'Property deleted.');
    }

    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $path = app(MediaService::class)->upload($request->file('file'), 'properties/gallery');

        return response()->json(['url' => asset('storage/'.$path.'/large.webp'), 'path' => $path]);
    }
}
