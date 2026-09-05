{{--
    Shared <head> SEO block. Added 2026-09-03 — the layout previously had a
    bare <title> and nothing else, so shared links produced no preview at all.

    Pages override the defaults with @section('meta_description', '...'),
    @section('meta_image', asset('...')) (must be an absolute URL) and
    @section('meta_type', 'article'), and push structured data with
    @push('schema').
--}}
@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'noindex' => false,
])

@php
    $siteName = config('site.name');
    $metaTitle = trim($title ?: $siteName);
    $metaDescription = trim($description ?: config('site.description'));
    $metaImage = $image ?: asset(config('site.og_image'));
    $canonical = url()->current();
@endphp

<link rel="canonical" href="{{ $canonical }}">
<meta name="description" content="{{ $metaDescription }}">
@if ($noindex)
    <meta name="robots" content="noindex, nofollow">
@else
    <meta name="robots" content="index, follow, max-image-preview:large">
@endif

{{-- Open Graph (Facebook, WhatsApp link previews) --}}
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:locale" content="{{ config('site.locale') }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:image:alt" content="{{ $siteName }}">

{{-- Twitter / X --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $metaImage }}">

<meta name="theme-color" content="#FFE522">
