<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\View\View;

class PropertiesController extends Controller
{
    public function __invoke(): View
    {
        $properties = Property::query()
            ->orderByDesc('created_at')
            ->get();

        return view('pages.properties', compact('properties'));
    }
}
