@extends('layouts.cms')

@section('title', 'Inquiries | PREC CMS')
@section('page_title', 'Inquiries')
@section('page_subtitle', 'Central inbox for website and service inquiries.')

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6">
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center gap-3">
                <div class="flex-1">
                    <div class="relative">
                        <input type="search" name="search" form="inquiryFilters" value="{{ request('search') }}"
                            placeholder="Search by name, email, property, service..."
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                        <i data-lucide="search" class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2"></i>
                    </div>
                </div>
                <form id="inquiryFilters" method="GET" action="{{ route('cms.inquiries.index') }}"
                    class="flex flex-wrap gap-2 items-center">
                    <x-ui.select name="type" class="bg-gray-50 border border-gray-100 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30 cursor-pointer">
                        <option value="">All Types</option>
                        <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General inquiries
                        </option>
                        <option value="service" {{ request('type') === 'service' ? 'selected' : '' }}>Service inquiries
                        </option>
                        <option value="property" {{ request('type') === 'property' ? 'selected' : '' }}>Property inquiries
                        </option>
                        <option value="appointment" {{ request('type') === 'appointment' ? 'selected' : '' }}>Appointment
                            requests</option>
                    </x-ui.select>
                    <button type="submit" class="btn-secondary">Filter</button>
                </form>
            </div>

            @if ($inquiries->isEmpty())
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                    <h3 class="font-heading text-3xl leading-none mb-2">No inquiries found</h3>
                    <p class="text-brand-black/60 max-w-xl mx-auto">When users submit inquiries on the website, they will
                        appear here. New inquiries will be highlighted.</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach ($inquiries as $inquiry)
                        <a href="{{ route('cms.inquiries.show', $inquiry) }}"
                            class="block px-6 py-5 hover:bg-gray-50 transition">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                <div>
                                    <div class="font-semibold text-brand-black">{{ $inquiry->name }}</div>
                                    <div class="text-sm text-brand-black/60">{{ $inquiry->email }} ·
                                        {{ ucfirst($inquiry->type) }}</div>
                                </div>
                                <div class="text-sm text-brand-black/50">{{ $inquiry->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    {{ $inquiries->withQueryString()->links() }}
                </div>
            @endif
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-2">Inquiry Preview</h3>
            <p class="text-sm text-brand-black/60 mb-6">Click any inquiry to view details and delete it.</p>

            <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <p class="text-sm text-brand-black/60">Select an inquiry from the list to open its detail page.</p>
            </div>
        </div>
    </div>
@endsection
