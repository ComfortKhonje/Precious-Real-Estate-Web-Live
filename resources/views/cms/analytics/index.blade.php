@extends('layouts.cms')

@section('title', 'Analytics | PREC CMS')
@section('page_title', 'Analytics')
@section('page_subtitle', 'Traffic, inquiries, and listing activity at a glance.')

@section('content')
    {{-- Period filter — drives the two time-bound KPIs and Most Viewed Pages below.
         Everything else (totals, breakdowns) is a snapshot and stays constant. --}}
    <div class="flex flex-wrap items-center gap-2 mb-6">
        @foreach(['today' => 'Today', 'week' => 'This Week', 'month' => 'This Month', 'all' => 'All Time'] as $value => $label)
            <a href="{{ route('cms.analytics.index', ['period' => $value]) }}"
                class="px-5 py-2.5 rounded-full text-sm font-semibold transition {{ $period === $value ? 'bg-brand-black text-white' : 'bg-white border border-gray-200 text-brand-black/70 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- KPI row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50">Page Views</p>
                <div class="w-9 h-9 rounded-xl bg-primary/20 text-brand-black flex items-center justify-center">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="font-heading text-4xl leading-none">{{ number_format($periodViews) }}</div>
        </div>
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50">New Inquiries</p>
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="font-heading text-4xl leading-none">{{ number_format($periodInquiries) }}</div>
        </div>
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50">Total Inquiries</p>
                <div class="w-9 h-9 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                    <i data-lucide="inbox" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="font-heading text-4xl leading-none">{{ number_format($totalInquiries) }}</div>
        </div>
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50">Properties Listed</p>
                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <i data-lucide="home" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="font-heading text-4xl leading-none">{{ number_format($totalProperties) }}</div>
        </div>
    </div>

    {{-- Most viewed pages + recent inquiries --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-2xl leading-none mb-4">Most Viewed Pages</h3>
            @if($topPaths->isNotEmpty())
                <div class="space-y-2">
                    @foreach($topPaths as $row)
                        <div class="flex items-center justify-between gap-2 p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-mono text-brand-black/80 truncate">{{ $row->path }}</span>
                            <span class="px-2.5 py-1 rounded-full bg-primary/20 text-brand-black text-xs font-bold shrink-0">{{ $row->views }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-brand-black/60 py-6 text-center">No page views {{ $period === 'all' ? 'recorded yet' : 'in this period' }}.</p>
            @endif
        </div>

        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-6">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="font-heading text-2xl leading-none">Recent Inquiries</h3>
                <a href="{{ route('cms.inquiries.index') }}" class="text-primary hover:text-primary/80 font-semibold text-sm">View All</a>
            </div>
            @if($recentInquiries->isNotEmpty())
                <div class="space-y-2">
                    @foreach($recentInquiries as $inquiry)
                        <a href="{{ route('cms.inquiries.show', $inquiry) }}" class="flex items-center justify-between gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                            <div class="min-w-0">
                                <div class="font-semibold text-sm truncate">{{ $inquiry->name }}</div>
                                <div class="text-xs text-brand-black/60 truncate">
                                    {{ $inquiry->property_id ? (optional($inquiry->property)->title ?? 'Unknown property') : ($inquiry->type ?? 'General inquiry') }}
                                </div>
                            </div>
                            <div class="text-xs text-brand-black/50 whitespace-nowrap shrink-0">{{ $inquiry->created_at->diffForHumans() }}</div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-brand-black/60 py-6 text-center">No inquiries yet.</p>
            @endif
        </div>
    </div>

    {{-- Breakdowns --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-2xl leading-none mb-4">Inquiries by Type</h3>
            @if($inquiryTypeBreakdown->isNotEmpty())
                <div class="space-y-2">
                    @foreach($inquiryTypeBreakdown as $type)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-semibold">{{ $type->type ?? 'General' }}</span>
                            <span class="px-2.5 py-1 rounded-full bg-primary/20 text-brand-black text-xs font-bold">{{ $type->count }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-brand-black/60 py-6 text-center">No inquiry data yet.</p>
            @endif
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-2xl leading-none mb-4">Listings Snapshot</h3>
            <div class="grid grid-cols-2 gap-2">
                <div class="p-3 bg-green-50 rounded-xl text-center">
                    <div class="text-2xl font-heading">{{ $propertyStats['available'] }}</div>
                    <div class="text-xs font-semibold text-green-700 mt-0.5">Available</div>
                </div>
                <div class="p-3 bg-orange-50 rounded-xl text-center">
                    <div class="text-2xl font-heading">{{ $propertyStats['unavailable'] }}</div>
                    <div class="text-xs font-semibold text-orange-700 mt-0.5">Unavailable</div>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl text-center">
                    <div class="text-2xl font-heading">{{ $propertyStats['for_sale'] }}</div>
                    <div class="text-xs font-semibold text-blue-700 mt-0.5">For Sale</div>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl text-center">
                    <div class="text-2xl font-heading">{{ $propertyStats['for_rent'] }}</div>
                    <div class="text-xs font-semibold text-indigo-700 mt-0.5">For Rent</div>
                </div>
            </div>
            <div class="mt-2 flex items-center justify-between p-3 bg-purple-50 rounded-xl">
                <span class="text-sm font-semibold text-purple-700 flex items-center gap-1.5">
                    <i data-lucide="star" class="w-3.5 h-3.5"></i> Featured
                </span>
                <span class="px-2.5 py-1 rounded-full bg-purple-200 text-purple-700 text-xs font-bold">{{ $propertyStats['featured'] }}</span>
            </div>
        </div>
    </div>
@endsection
