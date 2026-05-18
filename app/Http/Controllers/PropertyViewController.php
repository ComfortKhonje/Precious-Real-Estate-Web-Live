<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PropertyViewController extends Controller
{
    public function show(string $id): View
    {
        return view('pages.property-view', ['propertyId' => $id]);
    }
}
