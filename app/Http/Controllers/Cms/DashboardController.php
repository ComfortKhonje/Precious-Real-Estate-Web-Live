<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Property;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalProperties = Property::count();
        $featuredProperties = Property::where('is_featured', true)->count();
        $availableProperties = Property::where('is_available', true)->count();
        
        // Placeholders for now
        $totalInquiries = 0;
        $newInquiries = 0;
        $publishedAnnouncements = 0;

        return view('cms.dashboard', compact(
            'totalProperties',
            'featuredProperties',
            'availableProperties',
            'totalInquiries',
            'newInquiries',
            'publishedAnnouncements'
        ));
    }
}
