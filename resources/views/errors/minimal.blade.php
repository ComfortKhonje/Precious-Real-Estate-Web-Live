<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Something went wrong' }} | Precious Real Estate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body bg-brand-white text-brand-black min-h-screen">
    <div class="relative min-h-screen flex items-center justify-center px-6 py-16 overflow-hidden">
        <img src="{{ asset('brand-assets/website-pages/grid-background.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-10 pointer-events-none">

        <div class="relative z-10 w-full max-w-2xl bg-white/95 border border-gray-200 rounded-3xl p-8 md:p-12 shadow-sm text-center">
            <p class="text-sm tracking-[0.2em] uppercase text-brand-black/50 mb-3">Error {{ $code ?? 'Error' }}</p>
            <h1 class="font-heading text-5xl md:text-6xl leading-none mb-4">{{ $title ?? 'Something went wrong' }}</h1>
            <p class="text-brand-black/70 text-lg leading-relaxed max-w-xl mx-auto">{{ $message ?? 'An unexpected issue occurred. Please try again in a moment.' }}</p>

            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-black text-white font-semibold tracking-wide hover:opacity-90 transition">
                    Go to Home
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full border border-brand-black text-brand-black font-semibold tracking-wide hover:bg-brand-black hover:text-white transition">
                    Contact Support
                </a>
                <a href="{{ route('inquiry') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full border border-primary text-brand-black font-semibold tracking-wide hover:bg-primary transition">
                    Make Inquiry
                </a>
            </div>
        </div>
    </div>
</body>
</html>
