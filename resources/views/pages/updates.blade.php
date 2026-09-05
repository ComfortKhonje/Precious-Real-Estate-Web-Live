@extends('layouts.app')

@section('title', 'Updates & News - Precious Real Estate')
@section('meta_description', 'Public announcements, notices, and property market updates from Precious Real Estate Consulting.')

@section('content')
    <x-updates.page-hero />
    <x-updates.updates-list :news="$news" :featured="$featured" :active-category="$activeCategory" :category-counts="$categoryCounts" />
    <x-shared.cta-get-started />
@endsection

