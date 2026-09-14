@extends('layouts.app')
@section('title', 'Inquiry - Precious Real Estate')

@section('content')
    {{-- Custom Header for Inquiry Page --}}
    <div class="relative z-50 pt-6 md:pt-8 px-4 md:px-12 flex flex-row justify-between items-center gap-6">
        {{-- Mobile: Circle Back Button | Desktop: Full Button --}}
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" class="md:hidden w-12 h-12 rounded-full flex items-center justify-center text-brand-black/30 border-2 border-brand-black/30 hover:bg-primary transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <a href="{{ route('home') }}" class="hidden md:flex btn-secondary items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                BACK TO MAIN WEBSITE
            </a>
        </div>

        {{-- Desktop only Title --}}
        <h1 class="hidden md:block text-3xl font-heading text-brand-black uppercase">Make an Inquiry</h1>

        {{-- Logo: Right on mobile, center/rightish on desktop --}}
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img loading="lazy" decoding="async" src="{{ asset('brand-assets/1. Logo Suite/2. Primary Logo Lockup/PNG/primary-logo-white-bg.png') }}" alt="Logo" class="h-12 md:h-16">
        </a>
    </div>

    <x-inquiry.inquiry-form :property_id="request()->query('property_id')" />

    <x-shared.inquiry-footer />
@endsection

@push('styles')
<style>
    /* Hide the default navbar and footer for this page */
    #main-navbar, #main-footer { display: none !important; }
</style>
@endpush
