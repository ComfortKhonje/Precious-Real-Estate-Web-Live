<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\PageView;
use App\Models\Property;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    private const PERIODS = ['today', 'week', 'month', 'all'];

    public function index(Request $request)
    {
        $period = $request->get('period', 'week');
        if (! in_array($period, self::PERIODS, true)) {
            $period = 'week';
        }

        $since = match ($period) {
            'today' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            default => null,
        };

        $periodViews = PageView::query()->when($since, fn ($q) => $q->where('created_at', '>=', $since))->count();
        $periodInquiries = Inquiry::query()->when($since, fn ($q) => $q->where('created_at', '>=', $since))->count();

        $topPaths = PageView::selectRaw('path, COUNT(*) as views')
            ->when($since, fn ($q) => $q->where('created_at', '>=', $since))
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        $totalInquiries = Inquiry::count();
        $totalProperties = Property::count();

        $recentInquiries = Inquiry::latest()->limit(5)->get();

        $inquiryTypeBreakdown = Inquiry::select('type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('type')
            ->orderByDesc('count')
            ->get();

        $propertyStats = [
            'available' => Property::where('is_available', true)->count(),
            'unavailable' => Property::where('is_available', false)->count(),
            'for_sale' => Property::where('status', 'For Sale')->count(),
            'for_rent' => Property::where('status', 'For Rent')->count(),
            'featured' => Property::where('is_featured', true)->count(),
        ];

        return view('cms.analytics.index', compact(
            'period',
            'periodViews',
            'periodInquiries',
            'topPaths',
            'totalInquiries',
            'totalProperties',
            'recentInquiries',
            'inquiryTypeBreakdown',
            'propertyStats',
        ));
    }
}
