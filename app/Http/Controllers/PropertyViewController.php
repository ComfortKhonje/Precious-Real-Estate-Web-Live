<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\View\View;

class PropertyViewController extends Controller
{
    public function show(string $id): View
    {
        $property = Property::findOrFail($id);

        return view('pages.property-view', compact('property'));
    }
}
