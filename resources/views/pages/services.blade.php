@extends('layouts.app')
@section('title', 'Services - Precious Real Estate Consulting')
@section('meta_description', 'Property valuation, property management, property development, sales and letting, and title deed processing — delivered by registered valuers in Lilongwe and Blantyre.')
@section('content')
    <x-services.page-hero />
    <x-services.service-details :services="$services" />
    <x-home.cta badge="Get Started" title="Need Help with Any of Our Services?"
        description="Our team is ready to provide professional guidance tailored to your needs." />
@endsection
