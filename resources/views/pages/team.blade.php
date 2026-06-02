@extends('layouts.app')
@section('title', 'Our Team - Precious Real Estate')
@section('content')
    <x-team.page-hero />
    <x-team.who-we-are />
    <x-team.meet-the-team :team-members="$teamMembers" />
    <x-team.our-commitment />
    <x-home.cta badge="Work With Our Team" title="Need Professional Property Assistance?"
        description="Get in touch with our team for trusted real estate support and advisory services." />
@endsection
