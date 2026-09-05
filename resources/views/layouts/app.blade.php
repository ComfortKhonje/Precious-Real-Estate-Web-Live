<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('site.name') . ' — ' . config('site.tagline'))</title>

    {{-- SEO: description, canonical, Open Graph, Twitter card.
         Added 2026-09-03; pages override via @section('meta_description')
         / @section('meta_image') / @section('meta_type'). --}}
    <x-seo.meta
        :title="trim($__env->yieldContent('title', config('site.name')))"
        :description="trim($__env->yieldContent('meta_description', config('site.description')))"
        :image="trim($__env->yieldContent('meta_image', asset(config('site.og_image'))))"
        :type="trim($__env->yieldContent('meta_type', 'website'))" />

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Barlow Condensed (headings) + Outfit (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- GSAP for premium loading and micro-animations. `defer` added
         2026-09-02 — was loading synchronously, blocking first paint on
         every page for a third-party script fetch. --}}
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    {{-- Alpine.js for interactive UI components --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    {{-- Organisation-level structured data, on every page. Individual pages
         push their own more specific schema (e.g. RealEstateListing). --}}
    <script type="application/ld+json">@json(\App\Support\Schema::organization(), JSON_UNESCAPED_SLASHES)</script>
    @stack('schema')

    {{-- Google Analytics (GA4) — safe no-op until GOOGLE_ANALYTICS_ID is set
         in .env. See config/services.php for context. --}}
    @if(config('services.google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics_id') }}');
        </script>
    @endif
</head>

<body class="font-body text-brand-black antialiased min-h-screen flex flex-col">
    {{-- Keyboard users shouldn't have to tab through the whole nav on every
         page before reaching the content. Visually hidden until focused. --}}
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:top-4 focus:left-4 focus:bg-brand-black focus:text-primary focus:px-5 focus:py-3 focus:rounded-full focus:font-semibold">
        Skip to main content
    </a>

    {{-- Shared navigation --}}
    <x-shared.navbar />

    <main id="main-content" class="relative z-20 flex-grow flex flex-col">
        @yield('content')
    </main>

    {{-- Shared footer --}}
    <x-shared.footer />

    @stack('scripts')
</body>

</html>