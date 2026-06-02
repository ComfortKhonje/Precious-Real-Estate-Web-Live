@extends('layouts.app')
@section('title', 'Services - Precious Real Estate')
@section('content')
    <x-services.page-hero />
    <x-services.service-details :services="$services" />
    <x-home.cta badge="Get Started" title="Need Help with Any of Our Services?"
        description="Our team is ready to provide professional guidance tailored to your needs." />
@endsection
