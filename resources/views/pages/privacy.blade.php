@extends('layouts.app')
@section('title', 'Privacy Policy - Precious Real Estate')
@section('content')
    <x-legal.privacy-content />
    <x-shared.contact-info
    :overlap="true" />
@endsection
