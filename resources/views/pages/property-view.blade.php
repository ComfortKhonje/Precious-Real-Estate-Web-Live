@extends('layouts.app')
@section('title', isset($property) ? $property->title . ' - Precious Real Estate' : 'Property - Precious Real Estate')
@section('content')
    <x-property-view.property-images :property="$property" />
    <x-property-view.property-info :property="$property" />
    <x-property-view.property-cta :property="$property" />
@endsection
