<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index(Request $request)
    {
        // Only ever-listed properties on the public read endpoint — this
        // feeds the public site's "Load More" pagination directly.
        $query = Property::where('is_available', true);

        if ($request->filled('search')) {
            $s = $request->get('search');
            $query->where('title', 'like', "%{$s}%")->orWhere('location', 'like', "%{$s}%");
        }

        // Page size matches the properties page's initial server-rendered
        // page (6) so "Load More" pages feel consistent, not jarring.
        return response()->json(
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->paginate(6)
        );
    }

    public function show(Property $property)
    {
        return response()->json($property);
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
            'features' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
            'media' => 'nullable|array',
        ]);

        $property = Property::create($data);

        return response()->json($property, 201);
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
            'features' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
            'media' => 'nullable|array',
        ]);

        $property->update($data);

        return response()->json($property);
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return response()->json(['deleted' => true]);
    }
}
