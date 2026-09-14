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
        // feeds the public site's "Load More" pagination directly. Shares
        // Property::scopeFilter() with the web properties page so paginating
        // past page 1 respects whatever search/location/type/status/price
        // filter is active instead of silently falling back to unfiltered
        // results (this endpoint only ever implemented `search` before,
        // fixed 2026-09-08).
        $query = Property::where('is_available', true)->filter($request);

        // Page size matches the properties page's initial server-rendered
        // page (6) so "Load More" pages feel consistent, not jarring.
        return response()->json(
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->paginate(6)
        );
    }
}
