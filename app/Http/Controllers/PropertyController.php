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
        $properties = Property::where('is_available', true)
                           ->filter($request)
                           ->orderBy('is_featured', 'desc')
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
        // Two real bugs here, fixed 2026-09-08:
        // 1. No is_available filter — a sold/let listing could get
        //    recommended as "related" to a live one.
        // 2. Exact-type match with no fallback and no ordering — a property
        //    whose type has no other listings (e.g. the site's only
        //    Apartment) showed an empty "Related Listings" section with
        //    nothing in it, hiding the section entirely instead of
        //    surfacing anything relevant.
        // Now: same type first, same category as a wider net within the
        // same query, ordered so featured/newest lead — and if literally
        // nothing matches either (only possible if this is the one and
        // only available listing on the whole site), falls back to any
        // other available properties rather than showing nothing.
        $relatedProperties = Property::where('id', '!=', $property->id)
            ->where('is_available', true)
            ->where(function ($query) use ($property) {
                $query->where('type', $property->type)
                      ->orWhere('category', $property->category);
            })
            ->orderByRaw('type = ? desc', [$property->type])
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        if ($relatedProperties->isEmpty()) {
            $relatedProperties = Property::where('id', '!=', $property->id)
                ->where('is_available', true)
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        }

        return view('pages.property-details', compact('property', 'relatedProperties'));
    }
}
