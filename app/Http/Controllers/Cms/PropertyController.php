<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $query = Property::query();

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $locations = Property::select('location')->distinct()->pluck('location');
        $types = Property::select('type')->distinct()->pluck('type');

        return view('cms.properties.index', compact('properties', 'locations', 'types'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        return view('cms.properties.create');
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'status' => 'required|string|in:For Sale,For Rent',
            'type' => 'required|string|max:255',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'land_size' => 'nullable|string|max:255',
            'parking_spaces' => 'nullable|integer|min:0',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Handle Featured Image
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('properties/featured', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        }

        // Handle Gallery
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('properties/gallery', 'public');
                $galleryPaths[] = 'storage/' . $path;
            }
        }
        $validated['gallery'] = $galleryPaths;

        Property::create($validated);

        return redirect()->route('cms.properties.index')->with('success', 'Property created successfully.');
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        return view('cms.properties.edit', compact('property'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'status' => 'required|string|in:For Sale,For Rent',
            'type' => 'required|string|max:255',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'land_size' => 'nullable|string|max:255',
            'parking_spaces' => 'nullable|integer|min:0',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_available'] = $request->has('is_available');

        // Handle Featured Image
        if ($request->hasFile('featured_image')) {
            // Delete old image if it exists and is not a default asset
            if ($property->featured_image && !str_starts_with($property->featured_image, 'brand-assets')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $property->featured_image));
            }
            $path = $request->file('featured_image')->store('properties/featured', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        }

        // Handle Gallery
        $galleryPaths = $property->gallery ?? [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('properties/gallery', 'public');
                $galleryPaths[] = 'storage/' . $path;
            }
        }
        $validated['gallery'] = $galleryPaths;

        $property->update($validated);

        return redirect()->route('cms.properties.index')->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        // Delete images
        if ($property->featured_image && !str_starts_with($property->featured_image, 'brand-assets')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $property->featured_image));
        }

        if ($property->gallery) {
            foreach ($property->gallery as $image) {
                if (!str_starts_with($image, 'brand-assets')) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $image));
                }
            }
        }

        $property->delete();

        return redirect()->route('cms.properties.index')->with('success', 'Property deleted successfully.');
    }
}
