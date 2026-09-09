@extends('layouts.app')
@section('title', 'Properties for Sale & Rent in Malawi - Precious Real Estate')
@section('meta_description', 'Browse houses, apartments, plots, land, offices and commercial property for sale and to let across Lilongwe, Blantyre and the rest of Malawi.')
@section('content')
<x-properties.page-hero />
<x-properties.property-search
    :initialProperties="$properties->items()"
    :currentPage="$properties->currentPage()"
    :lastPage="$properties->lastPage()"
/>
<x-home.cta badge="Get Started" title="Need Professional Property Assistance?"
    description="Our team is ready to support you with trusted real estate solutions." />
@endsection

{{-- The old #load-more/#property-grid AJAX script that used to live here was dead code —
     it targeted DOM ids that don't exist in <x-properties.property-search>, which owns
     the actual grid via Alpine. Removed 2026-09-02; "Load More" is now the loadMore()
     method inside that component, wired to the real /api/properties endpoint. --}}

@push('scripts')
<script>
    // The hero's search card floats half outside the hero section
    // (absolute + translate-y-1/2), and its height changes by breakpoint —
    // stacked filter fields on mobile/tablet, one row from lg: up. A fixed
    // padding-top on the results section either wasted space on desktop or
    // still hid content under the card on mobile. Measuring the card and
    // padding to exactly clear it (+ a little breathing room) works at every
    // breakpoint and keeps working if the card's content ever changes.
    // Added 2026-09-08.
    (function () {
        function syncOverlapPadding() {
            var card = document.getElementById('properties-hero-search-card');
            var results = document.getElementById('properties-search');
            if (!card || !results) return;

            results.style.paddingTop = (card.offsetHeight / 2 + 32) + 'px';
        }

        // This script tag sits at the end of the body, after both sections'
        // markup, so the elements already exist — no need to wait for
        // DOMContentLoaded. Still re-run on 'load' (fonts/images can still
        // shift the card's height after this point) and on resize.
        syncOverlapPadding();
        window.addEventListener('load', syncOverlapPadding);
        window.addEventListener('resize', syncOverlapPadding);
    })();
</script>
@endpush