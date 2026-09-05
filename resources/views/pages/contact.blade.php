@extends('layouts.app')
@section('title', 'Contact - Precious Real Estate Consulting')
@section('meta_description', 'Talk to Precious Real Estate Consulting about a valuation, a listing or property management. Offices in Area 47 Lilongwe and Haji Latif Pavilion Blantyre.')
@section('content')
    <x-contact.page-hero />
    <x-contact.contact-form />
    <x-contact.location-map />
    <x-home.cta
        badge="Need Assistance?"
        title="We're Ready to Help"
        description="Speak with our team for reliable and professional property guidance."
        :showContactInfo="false"
    />
@endsection
