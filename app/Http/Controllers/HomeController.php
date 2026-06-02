<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredProperties = Property::where('is_featured', true)
                                      ->where('is_available', true)
                                      ->take(3)
                                      ->get();

        return view('home', compact('featuredProperties'));
    }
}
