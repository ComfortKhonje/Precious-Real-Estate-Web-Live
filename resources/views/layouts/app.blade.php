<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Precious Real Estate')</title>

    {{-- Google Fonts: Barlow Condensed (headings) + Outfit (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-body text-brand-black bg-grid antialiased">
    <img src="{{ asset('brand-assets/website-pages/grid-background.png') }}" alt="Grid Background" class="fixed inset-0 w-full h-full object-cover opacity-20 z-0">

    {{-- Shared navigation --}}
    <x-shared.navbar />

    <main class="relative z-20">
        @yield('content')
    </main>

    {{-- Shared footer --}}
    <x-shared.footer />

    @stack('scripts')
</body>
</html>
