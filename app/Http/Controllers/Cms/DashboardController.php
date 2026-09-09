<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\Service;
use App\Models\TeamMember;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // Get real data from database
        $totalProperties = Property::count();
        $featuredProperties = Property::where('is_featured', true)->count();

        // Was matching a status vocabulary ('available'/'sold'/'rented'/
        // 'active') that never existed on this column — the 2026-09-02
        // property-form rebuild settled on 'For Sale'/'For Rent' as the only
        // real values (see Property::STATUSES), so these three counts were
        // always zero regardless of actual data. There's no "sold" vs
        // "rented" distinction in the schema — is_available=false just means
        // the listing is no longer active, whatever the reason. Fixed
        // 2026-09-08 to reflect what the data actually looks like.
        $forSaleProperties = Property::where('status', 'For Sale')->where('is_available', true)->count();
        $forRentProperties = Property::where('status', 'For Rent')->where('is_available', true)->count();
        $inactiveProperties = Property::where('is_available', false)->count();

        $totalInquiries = Inquiry::count();
        $newInquiries = Inquiry::where('created_at', '>=', now()->subDays(7))->count();
        $publishedAnnouncements = Announcement::where('status', 'published')->count();
        $draftAnnouncements = Announcement::where('status', 'draft')->count();
        // The overview cards only ever covered Properties/Inquiries/
        // Announcements — Services and Team, the other two real CMS content
        // types, had no presence on the dashboard at all. Added 2026-09-08.
        $activeServices = Service::where('visible', true)->count();
        $teamMembers = TeamMember::where('visible', true)->count();

        // Fetch recent activities
        $recentInquiries = Inquiry::latest()->take(5)->get();
        $recentProperties = Property::latest()->take(5)->get();

        $activities = collect()
            ->concat($recentInquiries->map(fn($inq) => [
                'type' => 'inquiry',
                'title' => "New inquiry from {$inq->name}",
                'subtitle' => $inq->email . ($inq->phone ? " ({$inq->phone})" : ''),
                'time' => $inq->created_at,
                'route' => route('cms.inquiries.show', $inq),
            ]))
            ->concat($recentProperties->map(fn($prop) => [
                'type' => 'property',
                'title' => "Property updated: {$prop->title}",
                'subtitle' => $prop->location . ' · ' . $prop->status,
                'time' => $prop->updated_at,
                'route' => route('cms.properties.edit', $prop),
            ]))
            ->sortByDesc('time')
            ->take(5);

        return view('cms.dashboard', compact(
            'totalProperties',
            'featuredProperties',
            'forSaleProperties',
            'forRentProperties',
            'inactiveProperties',
            'totalInquiries',
            'newInquiries',
            'publishedAnnouncements',
            'draftAnnouncements',
            'activeServices',
            'teamMembers',
            'activities'
        ));
    }
}
