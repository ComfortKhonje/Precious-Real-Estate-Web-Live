<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $services = Service::query()
            ->where('visible', true)
            ->orderBy('title')
            ->get();

        $featuredProperties = Property::query()
            ->where('is_featured', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('home', compact('services', 'featuredProperties'));
    }
}
