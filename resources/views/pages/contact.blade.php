@extends('layouts.app')
@section('title', 'Contact - Precious Real Estate')
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
