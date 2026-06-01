@extends('layouts.cms')

@section('title', 'Services Content | PREC CMS')
@section('page_title', 'Services Content')
@section('page_subtitle', 'Edit website service descriptions and visibility.')

@section('content')
    @php
        $services = [
            ['title' => 'Property Valuation', 'updated' => 'Not yet', 'visible' => true],
            ['title' => 'Property Management', 'updated' => 'Not yet', 'visible' => true],
            ['title' => 'Property Development', 'updated' => 'Not yet', 'visible' => true],
            ['title' => 'Property Sales & Letting', 'updated' => 'Not yet', 'visible' => true],
            ['title' => 'Title Deed Processing', 'updated' => 'Not yet', 'visible' => true],
        ];
    @endphp

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-heading text-3xl leading-none">Services</h3>
                <span class="text-xs text-brand-black/50">{{ count($services) }} items</span>
            </div>
            <div class="p-3 space-y-2">
                @foreach($services as $s)
                    <a href="{{ route('cms.services.edit', ['slug' => str($s['title'])->slug()]) }}"
                       class="block px-4 py-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition border border-gray-100">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <div class="font-semibold">{{ $s['title'] }}</div>
                                <div class="text-xs text-brand-black/50 mt-1">Last updated: {{ $s['updated'] }}</div>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full {{ $s['visible'] ? 'bg-primary/40 text-brand-black' : 'bg-gray-200 text-gray-600' }}">
                                {{ $s['visible'] ? 'Visible' : 'Hidden' }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-2">Service Editor</h3>
            <p class="text-sm text-brand-black/60 mb-6">Select a service on the left to edit. Editor wiring is frontend-only for now.</p>

            <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <p class="font-semibold">Choose a service to edit</p>
                <p class="text-sm text-brand-black/60 mt-1">You will be able to save drafts and publish updates.</p>
            </div>
        </div>
    </div>
@endsection

