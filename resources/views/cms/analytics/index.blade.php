@extends('layouts.cms')

@section('title', 'Analytics | PREC CMS')
@section('page_title', 'Analytics')
@section('page_subtitle', 'Overview of inquiries, properties, and content engagement.')

@section('content')
    @php
        use App\Models\Inquiry;
        use App\Models\PageView;
        use App\Models\Property;

        $totalInquiries = Inquiry::count();
        $inquiriesThisMonth = Inquiry::where('created_at', '>=', now()->startOfMonth())->count();
        $inquiriesThisWeek = Inquiry::where('created_at', '>=', now()->startOfWeek())->count();
        $totalProperties = Property::count();

        // Self-hosted pageview counter (TrackPageView middleware, added
        // 2026-09-02) — this is a rough traffic count, not full analytics.
        // See config('services.google_analytics_id') for the real-GA hook.
        $viewsToday = PageView::whereDate('created_at', today())->count();
        $viewsThisWeek = PageView::where('created_at', '>=', now()->startOfWeek())->count();
        $viewsThisMonth = PageView::where('created_at', '>=', now()->startOfMonth())->count();
        $viewsAllTime = PageView::count();
        $topPaths = PageView::selectRaw('path, COUNT(*) as views')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(8)
            ->get();
    @endphp

    <div class="mb-6">
        <h3 class="font-heading text-2xl leading-none mb-1">Website Traffic</h3>
        <p class="text-sm text-brand-black/60 mb-4">Self-hosted pageview count — rough traffic, not full analytics (no bounce rate, no session duration).
            @unless(config('services.google_analytics_id'))
                Real Google Analytics isn't connected yet — add <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">GOOGLE_ANALYTICS_ID</code> to <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">.env</code> once a GA4 property exists.
            @endunless
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">Today</p>
                <div class="font-heading text-5xl leading-none">{{ $viewsToday }}</div>
            </div>
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">This Week</p>
                <div class="font-heading text-5xl leading-none">{{ $viewsThisWeek }}</div>
            </div>
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">This Month</p>
                <div class="font-heading text-5xl leading-none">{{ $viewsThisMonth }}</div>
            </div>
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">All Time</p>
                <div class="font-heading text-5xl leading-none">{{ $viewsAllTime }}</div>
            </div>
        </div>
        @if($topPaths->isNotEmpty())
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <h4 class="font-heading text-xl mb-4">Most Viewed Pages (last 30 days)</h4>
                <div class="space-y-2">
                    @foreach($topPaths as $row)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-mono">{{ $row->path }}</span>
                            <span class="px-3 py-1 rounded-full bg-primary/20 text-brand-black text-sm font-semibold">{{ $row->views }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">Total Inquiries</p>
            <div class="flex items-end justify-between">
                <div class="font-heading text-5xl leading-none">{{ $totalInquiries }}</div>
                <div class="w-10 h-10 rounded-2xl bg-primary/40 border border-primary/50 text-primary flex items-center justify-center text-sm font-semibold">
                    📧
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">This Month</p>
            <div class="flex items-end justify-between">
                <div class="font-heading text-5xl leading-none">{{ $inquiriesThisMonth }}</div>
                <div class="w-10 h-10 rounded-2xl bg-blue-100 border border-blue-200 text-blue-600 flex items-center justify-center text-sm font-semibold">
                    📅
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">This Week</p>
            <div class="flex items-end justify-between">
                <div class="font-heading text-5xl leading-none">{{ $inquiriesThisWeek }}</div>
                <div class="w-10 h-10 rounded-2xl bg-green-100 border border-green-200 text-green-600 flex items-center justify-center text-sm font-semibold">
                    📈
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">Properties</p>
            <div class="flex items-end justify-between">
                <div class="font-heading text-5xl leading-none">{{ $totalProperties }}</div>
                <div class="w-10 h-10 rounded-2xl bg-purple-100 border border-purple-200 text-purple-600 flex items-center justify-center text-sm font-semibold">
                    🏠
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Recent Inquiries -->
        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-6">
            <div class="flex items-center justify-between gap-4 mb-5">
                <div>
                    <h3 class="font-heading text-3xl leading-none">Recent Inquiries</h3>
                    <p class="text-sm text-brand-black/60">Latest 5 inquiries submitted.</p>
                </div>
                <a href="{{ route('cms.inquiries.index') }}" class="text-primary hover:text-primary/80 font-semibold text-sm">View All</a>
            </div>

            @php
                $recentInquiries = Inquiry::latest()->limit(5)->get();
            @endphp

            @if ($recentInquiries->count() > 0)
                <div class="space-y-3">
                    @foreach ($recentInquiries as $inquiry)
                        <a href="{{ route('cms.inquiries.show', $inquiry) }}" class="block p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold text-sm">{{ $inquiry->name }}</div>
                                    <div class="text-xs text-brand-black/60 mt-1">{{ $inquiry->email }}</div>
                                    @if ($inquiry->property_id)
                                        <div class="text-xs text-primary font-semibold mt-2">Property: {{ optional($inquiry->property)->title ?? 'Unknown' }}</div>
                                    @endif
                                </div>
                                <div class="text-right whitespace-nowrap">
                                    <div class="text-xs text-brand-black/60">{{ $inquiry->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                    <p class="text-sm text-brand-black/60">No inquiries yet.</p>
                </div>
            @endif
        </div>

        <!-- Top Properties -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <div class="mb-5">
                <h3 class="font-heading text-3xl leading-none">Featured Properties</h3>
                <p class="text-sm text-brand-black/60">Your featured listings.</p>
            </div>

            @php
                $featuredProperties = Property::where('is_featured', true)->limit(5)->get();
            @endphp

            @if ($featuredProperties->count() > 0)
                <div class="space-y-3">
                    @foreach ($featuredProperties as $property)
                        <a href="{{ route('cms.properties.index') }}" class="block p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition">
                            <div class="font-semibold text-sm">{{ $property->title }}</div>
                            <div class="text-xs text-brand-black/60 mt-1">{{ $property->location ?? 'No location' }}</div>
                            <div class="text-xs text-primary font-semibold mt-2">⭐ Featured</div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                    <p class="text-sm text-brand-black/60">No featured properties.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Inquiry Types Breakdown -->
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-5">Inquiry Types</h3>
            
            @php
                $inquiryTypeBreakdown = Inquiry::select('type')
                    ->selectRaw('COUNT(*) as count')
                    ->groupBy('type')
                    ->orderByDesc('count')
                    ->get();
            @endphp

            @if ($inquiryTypeBreakdown->count() > 0)
                <div class="space-y-3">
                    @foreach ($inquiryTypeBreakdown as $type)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-semibold capitalize">{{ $type->type ?? 'General' }}</span>
                            <span class="px-3 py-1 rounded-full bg-primary/20 text-primary text-sm font-semibold">{{ $type->count }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-sm text-brand-black/60">
                    No inquiry data yet.
                </div>
            @endif
        </div>

        <!-- Property Status -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-5">Properties Status</h3>

            {{-- 2026-09-02: was checking status against 'available'/'Available'/'active'/'Active'
                 and 'sold'/'Sold'/'rented'/'Rented' — none of which are real values (canonical
                 status is 'For Sale'/'For Rent'; availability is the separate is_available
                 boolean). Always showed zero for both rows regardless of real data. --}}
            @php
                $availableCount = Property::where('is_available', true)->count();
                $unavailableCount = Property::where('is_available', false)->count();
                $forSaleCount = Property::where('status', 'For Sale')->count();
                $forRentCount = Property::where('status', 'For Rent')->count();
                $featuredCount = Property::where('is_featured', true)->count();
            @endphp

            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                    <span class="text-sm font-semibold">Available</span>
                    <span class="px-3 py-1 rounded-full bg-green-200 text-green-700 text-sm font-semibold">{{ $availableCount }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl">
                    <span class="text-sm font-semibold">Unavailable</span>
                    <span class="px-3 py-1 rounded-full bg-orange-200 text-orange-700 text-sm font-semibold">{{ $unavailableCount }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                    <span class="text-sm font-semibold">For Sale</span>
                    <span class="px-3 py-1 rounded-full bg-blue-200 text-blue-700 text-sm font-semibold">{{ $forSaleCount }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-indigo-50 rounded-xl">
                    <span class="text-sm font-semibold">For Rent</span>
                    <span class="px-3 py-1 rounded-full bg-indigo-200 text-indigo-700 text-sm font-semibold">{{ $forRentCount }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl">
                    <span class="text-sm font-semibold">Featured</span>
                    <span class="px-3 py-1 rounded-full bg-purple-200 text-purple-700 text-sm font-semibold">{{ $featuredCount }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

