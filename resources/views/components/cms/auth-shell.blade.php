@props(['title', 'subtitle'])

{{-- Minimal page shell for the CMS forgot/reset password screens. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} | PREC CMS</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body text-brand-black bg-brand-white bg-grid min-h-screen flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-md bg-white/95 border border-gray-200 rounded-3xl p-8 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-primary text-brand-black flex items-center justify-center font-heading text-2xl">P</div>
            <div class="leading-tight">
                <div class="font-heading text-3xl">PREC CMS</div>
                <div class="text-sm text-brand-black/60">{{ $subtitle }}</div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 p-4 rounded-2xl bg-green-50 border border-green-100 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-100 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif

        {{ $slot }}
    </div>
</body>
</html>
