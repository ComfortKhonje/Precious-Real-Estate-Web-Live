@extends('layouts.app')

@section('title', 'Home - Precious Real Estate Consulting')

@section('content')
    <div class="bg-grid">
        <x-home.hero />
        <x-home.stats />
        <x-home.services :services="$services" />
        <x-home.about />
        <x-home.featured-properties :properties="$featuredProperties" />
        <x-home.advantages />
        <x-home.cta />
    </div>
@endsection
