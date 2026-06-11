@extends('layouts.app')
@section('title', 'Properties - Precious Real Estate')
@section('content')
    <x-properties.page-hero />
    <x-properties.property-search :initialProperties="$properties" />
    <x-home.cta badge="Get Started" title="Need Professional Property Assistance?"
        description="Our team is ready to support you with trusted real estate solutions." />
@endsection
