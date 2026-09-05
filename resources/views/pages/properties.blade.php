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