<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Property;
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

        $data['features'] = $data['features'] ? array_map('trim', explode(',', $data['features'])) : [];
        $data['media'] = $data['media'] ? json_decode($data['media'], true) : [];

        Property::create($data);

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

        $data['features'] = $data['features'] ? array_map('trim', explode(',', $data['features'])) : [];
        $data['media'] = $data['media'] ? json_decode($data['media'], true) : [];

        $property->update($data);

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
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->store('properties', 'public');

        return response()->json(['url' => asset('storage/' . $path), 'path' => $path]);
    }
}
