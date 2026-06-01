@extends('layouts.app')
@section('title', 'Home - Precious Real Estate')
@section('content')
    <x-home.hero />
    <x-home.stats />
    <x-home.services-overview />
    <x-home.about-snippet />
    <x-home.available-properties />
    <x-home.advantages />
    <x-shared.cta-get-started />
    <x-shared.contact-info />
@endsection
