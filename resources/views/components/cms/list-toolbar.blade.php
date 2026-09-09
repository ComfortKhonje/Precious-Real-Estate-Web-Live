@props([
    'searchRoute' => null,
    'searchValue' => null,
    'searchPlaceholder' => 'Search…',
    'clearRoute' => null,
    'createRoute' => null,
    'createLabel' => 'Add New',
])

{{-- Shared toolbar row (search + filter slot + primary action) used on
     every CMS list page — properties, services, announcements, team
     members — so filtering/creating works and looks the same everywhere. --}}
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-6">
    @if($searchRoute)
        <form method="GET" action="{{ $searchRoute }}" class="flex-1 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 min-w-[220px]">
                <input type="text" name="search" value="{{ $searchValue }}" placeholder="{{ $searchPlaceholder }}"
                    class="w-full bg-white border border-gray-200 rounded-2xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                <i data-lucide="search" class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
            @isset($filters)
                <div class="flex flex-wrap gap-2">
                    {{ $filters }}
                    @if($clearRoute)
                        <a href="{{ $clearRoute }}" class="p-3 rounded-2xl bg-gray-100 text-brand-black/60 hover:bg-gray-200 transition" title="Clear Filters">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </a>
                    @endif
                </div>
            @endisset
        </form>
    @elseif(isset($filters))
        <div class="flex-1 flex flex-wrap gap-2">{{ $filters }}</div>
    @else
        <div class="flex-1"></div>
    @endif

    @if($createRoute)
        <a href="{{ $createRoute }}" class="btn-primary inline-flex items-center gap-2 justify-center whitespace-nowrap">
            <i data-lucide="plus" class="w-4 h-4"></i> {{ $createLabel }}
        </a>
    @endif
</div>
