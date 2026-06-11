@extends('layouts.cms')

@section('title', 'Dashboard Overview | PREC CMS')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Quick overview of properties, inquiries, and content.')

@section('content')
    @php
        $cards = [
            ['label' => 'Total Properties', 'value' => $totalProperties, 'icon' => 'home'],
            ['label' => 'Featured Properties', 'value' => $featuredProperties, 'icon' => 'star'],
            ['label' => 'Total Inquiries', 'value' => $totalInquiries, 'icon' => 'mail'],
            ['label' => 'New Inquiries', 'value' => $newInquiries, 'icon' => 'inbox'],
            ['label' => 'Published Announcements', 'value' => $publishedAnnouncements, 'icon' => 'megaphone'],
        ];
        $quickActions = [
            ['label' => 'Add Property', 'route' => 'cms.properties.create', 'icon' => 'plus'],
            ['label' => 'Add Announcement', 'route' => 'cms.announcements.create', 'icon' => 'megaphone'],
            ['label' => 'Edit Services', 'route' => 'cms.services.index', 'icon' => 'briefcase'],
            ['label' => 'View Inquiries', 'route' => 'cms.inquiries.index', 'icon' => 'mail'],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
        @foreach($cards as $c)
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">{{ $c['label'] }}</p>
                <div class="flex items-end justify-between">
                    <div class="font-heading text-5xl leading-none">{{ $c['value'] }}</div>
                    <div class="w-10 h-10 rounded-2xl bg-primary/20 border border-primary/30 flex items-center justify-center text-primary">
                        <i data-lucide="{{ $c['icon'] }}" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-6">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="font-heading text-3xl leading-none">Recent Activity</h3>
                    <p class="text-sm text-brand-black/60 mt-1">Latest inquiries and content changes.</p>
                </div>
                <div class="flex gap-2">
                    <a class="px-4 py-2 rounded-full bg-gray-100 text-sm font-semibold hover:bg-gray-200 transition" href="{{ route('cms.inquiries.index') }}">Inquiries</a>
                    <a class="px-4 py-2 rounded-full bg-gray-100 text-sm font-semibold hover:bg-gray-200 transition" href="{{ route('cms.properties.index') }}">Properties</a>
                </div>
            </div>

            @if ($activities->isEmpty())
                <div class="border border-dashed border-gray-200 rounded-2xl p-8 text-center">
                    <p class="text-sm text-brand-black/60">No activity yet.</p>
                    <p class="text-xs text-brand-black/50 mt-1">Once inquiries and content updates start coming in, they will appear here.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($activities as $act)
                        <div class="flex items-center justify-between p-4 border border-gray-50 rounded-2xl hover:bg-gray-50/50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-brand-black/70">
                                    @if ($act['type'] === 'inquiry')
                                        <i data-lucide="mail" class="w-5 h-5"></i>
                                    @else
                                        <i data-lucide="home" class="w-5 h-5"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-brand-black">{{ $act['title'] }}</p>
                                    <p class="text-xs text-brand-black/60">{{ $act['subtitle'] }}</p>
                                </div>
                            </div>
                            <div class="text-right flex items-center gap-3">
                                <span class="text-xs text-brand-black/45">{{ $act['time']->diffForHumans() }}</span>
                                <a href="{{ $act['route'] }}" class="text-xs font-semibold text-primary hover:underline">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-2">Quick Actions</h3>
            <p class="text-sm text-brand-black/60 mb-5">Shortcuts to common tasks.</p>

            <div class="grid grid-cols-1 gap-3">
                @foreach($quickActions as $action)
                    <a href="{{ route($action['route']) }}" class="flex items-center justify-between px-5 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold flex items-center gap-2">
                            <i data-lucide="{{ $action['icon'] }}" class="w-4 h-4 text-brand-black/60"></i>
                            {{ $action['label'] }}
                        </span>
                        <span class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center border border-gray-200">
                            <i data-lucide="chevron-right" class="w-5 h-5 text-brand-black/70"></i>
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-6 border border-gray-100 rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50">Property Status</p>
                        <p class="text-sm text-brand-black/60 mt-1">Available, sold, rented.</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-primary/20 border border-primary/30 flex items-center justify-center text-primary">
                        <i data-lucide="pie-chart" class="w-6 h-6"></i>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-between text-sm"><span>Available</span><span class="font-semibold">{{ $availableProperties }}</span></div>
                    <div class="flex items-center justify-between text-sm"><span>Sold</span><span class="font-semibold">{{ $soldProperties }}</span></div>
                    <div class="flex items-center justify-between text-sm"><span>Rented</span><span class="font-semibold">{{ $rentedProperties }}</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection

