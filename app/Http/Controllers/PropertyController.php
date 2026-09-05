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

        // Search by title/keywords
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

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

        // Filter by price range. The hero form submits human labels
        // ("K 200K", "K 1M", "K 20M+"), so they get parsed to a number here.
        // The previous hand-rolled str_replace chain stripped the leading
        // currency "K" and the "K" thousands suffix in the same pass, so
        // "K 200K" resolved to 200 instead of 200,000 — a 1000x-off filter
        // that quietly hid every listing. Fixed 2026-09-03.
        if ($request->filled('min_price')) {
            if (($min = $this->parsePriceLabel($request->input('min_price'))) !== null) {
                $query->where('price', '>=', $min);
            }
        }

        if ($request->filled('max_price')) {
            if (($max = $this->parsePriceLabel($request->input('max_price'))) !== null) {
                $query->where('price', '<=', $max);
            }
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

    /**
     * Turn a price-filter label into a number.
     * "K 200K" => 200000, "K 1M" => 1000000, "K 20M+" => 20000000.
     * Returns null for placeholder options ("", "Min", "Max").
     */
    private function parsePriceLabel(?string $label): ?float
    {
        $label = trim((string) $label);

        if ($label === '' || in_array($label, ['Min', 'Max'], true)) {
            return null;
        }

        // Drop a leading currency marker ("K ", "MWK ") and any trailing "+".
        $value = preg_replace('/^(MWK|K)\s+/i', '', $label);
        $value = rtrim($value, '+');

        if (! preg_match('/^([\d.,]+)\s*([KMB]?)$/i', trim($value), $matches)) {
            return null;
        }

        $number = (float) str_replace(',', '', $matches[1]);

        return match (strtoupper($matches[2])) {
            'K' => $number * 1_000,
            'M' => $number * 1_000_000,
            'B' => $number * 1_000_000_000,
            default => $number,
        };
    }
}
