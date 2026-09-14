<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | PREC CMS</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

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
                <div class="text-sm text-brand-black/60">Staff login</div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 p-4 rounded-2xl bg-green-50 border border-green-100 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-100 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('cms.login.submit') }}" class="space-y-4">
            @csrf
            <div class="space-y-1.5">
                <label class="text-xs tracking-widest text-gray-400 uppercase font-bold">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@preciousrealestate.mw" class="w-full bg-gray-100 rounded-xl py-4 px-5 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-md">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1.5">
                <label class="text-xs tracking-widest text-gray-400 uppercase font-bold">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full bg-gray-100 rounded-xl py-4 px-5 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-md">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('login') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-brand-black/70">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-black focus:ring-primary">
                    Remember me
                </label>
                <a href="{{ route('cms.password.request') }}" class="text-sm font-semibold text-brand-black hover:underline">Forgot password?</a>
            </div>

            <button type="submit" class="w-full mt-2 px-6 py-4 bg-brand-black text-white rounded-full font-bold uppercase tracking-widest hover:opacity-90 transition">
                Login
            </button>
        </form>

        <p class="mt-6 text-xs text-brand-black/60 leading-relaxed">
            For security, access is limited to authorized PREC staff.
            <a href="{{ route('home') }}" class="font-semibold text-brand-black hover:underline">Back to website</a>
        </p>
    </div>

    <x-shared.toast-container />
</body>
</html>

