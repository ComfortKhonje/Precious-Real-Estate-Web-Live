<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $query = Property::where('is_available', true);

        // Filter by location
        if ($request->filled('location') && $request->location !== 'Select Location') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by price range
        if ($request->filled('min_price') && $request->min_price !== 'Min') {
            $minPrice = (float) str_replace(['K', ' ', 'M', '+'], ['', '', '000000', ''], $request->min_price);
            if (str_contains($request->min_price, 'K') && !str_contains($request->min_price, 'M')) {
                $minPrice = (float) str_replace(['K', ' ', '+'], ['', '', '000'], $request->min_price);
            }
            $query->where('price', '>=', $minPrice);
        }

        if ($request->filled('max_price') && $request->max_price !== 'Max') {
            $maxPrice = (float) str_replace(['K', ' ', 'M', '+'], ['', '', '000000', ''], $request->max_price);
             if (str_contains($request->max_price, 'K') && !str_contains($request->max_price, 'M')) {
                $maxPrice = (float) str_replace(['K', ' ', '+'], ['', '', '000'], $request->max_price);
            }
            $query->where('price', '<=', $maxPrice);
        }

        $properties = $query->orderBy('is_featured', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(6);

        if ($request->ajax()) {
            return view('components.properties.property-grid-items', compact('properties'))->render();
        }

        return view('pages.properties', compact('properties'));
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        $relatedProperties = Property::where('id', '!=', $property->id)
                                     ->where('type', $property->type)
                                     ->take(3)
                                     ->get();

        return view('pages.property-details', compact('property', 'relatedProperties'));
    }
}
