<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredProperties = Property::where('is_featured', true)
                                      ->where('is_available', true)
                                      ->take(3)
                                      ->get();

        $services = Service::with('serviceIcon')
                           ->where('visible', true)
                           ->orderBy('title')
                           ->get();

        return view('home', compact('featuredProperties', 'services'));
    }
}
