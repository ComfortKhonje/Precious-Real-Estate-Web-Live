<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Inquiry;
use App\Models\Property;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // Get real data from database
        $totalProperties = Property::count();
        $featuredProperties = Property::where('is_featured', true)->count();

        // Match case-insensitively for available status
        $availableProperties = Property::whereIn('status', ['available', 'Available', 'active', 'Active'])->count();
        $soldProperties = Property::whereIn('status', ['sold', 'Sold'])->count();
        $rentedProperties = Property::whereIn('status', ['rented', 'Rented'])->count();

        $totalInquiries = Inquiry::count();
        $newInquiries = Inquiry::where('created_at', '>=', now()->subDays(7))->count();
        $publishedAnnouncements = Announcement::where('status', 'published')->count();

        // Fetch recent activities
        $recentInquiries = Inquiry::latest()->take(5)->get();
        $recentProperties = Property::latest()->take(5)->get();

        $activities = collect()
            ->concat($recentInquiries->map(fn ($inq) => [
                'type' => 'inquiry',
                'title' => "New inquiry from {$inq->name}",
                'subtitle' => $inq->email.($inq->phone ? " ({$inq->phone})" : ''),
                'time' => $inq->created_at,
                'route' => route('cms.inquiries.show', $inq),
            ]))
            ->concat($recentProperties->map(fn ($prop) => [
                'type' => 'property',
                'title' => "Property updated: {$prop->title}",
                'subtitle' => $prop->location.' · '.$prop->status,
                'time' => $prop->updated_at,
                'route' => route('cms.properties.edit', $prop),
            ]))
            ->sortByDesc('time')
            ->take(5);

        return view('cms.dashboard', compact(
            'totalProperties',
            'featuredProperties',
            'availableProperties',
            'soldProperties',
            'rentedProperties',
            'totalInquiries',
            'newInquiries',
            'publishedAnnouncements',
            'activities'
        ));
    }
}
