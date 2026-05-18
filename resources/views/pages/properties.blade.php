@extends('layouts.app')
@section('title', 'Properties — Precious Real Estate')
@section('content')
    <x-properties.page-hero />
    <x-properties.search-bar />
    <x-properties.available-properties />
    <x-shared.cta-get-started />
    <x-shared.contact-info />
@endsection
