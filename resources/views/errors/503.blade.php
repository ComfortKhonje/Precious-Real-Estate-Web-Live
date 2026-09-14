<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Under Maintenance | Precious Real Estate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body bg-brand-white text-brand-black min-h-screen">
    {{--
        Deliberately self-contained — no route()/ContactInfo::phone() calls
        (both hit the DB), no links back into the site. Every route is
        blocked while down, so a "Go to Home"/"Contact Us" button here
        would just show this same page again; worse, if the outage IS a
        database issue, a page that queries the DB to render its own
        "everything's fine, hang on" message could itself 500. Phone/email
        come straight from config/site.php, the same static defaults
        App\Support\ContactInfo falls back to.
    --}}
    <div class="relative min-h-screen flex items-center justify-center px-6 py-16 overflow-hidden bg-grid">

        <div class="relative z-10 w-full max-w-2xl bg-white/95 border border-gray-200 rounded-3xl p-8 md:p-12 shadow-sm text-center">
            <span class="badge-yellow">Scheduled Maintenance</span>
            <h1 class="font-heading text-5xl md:text-6xl leading-none mb-4">We'll Be Right Back</h1>
            <p class="text-brand-black/70 text-lg leading-relaxed max-w-xl mx-auto">
                We're making some improvements to the site. This won't take long —
                please check back shortly.
            </p>

            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="tel:{{ config('site.phones.0') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-black text-white font-semibold tracking-wide hover:opacity-90 transition">
                    Call Us: {{ config('site.phones.0') }}
                </a>
                <a href="mailto:{{ config('site.email') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full border border-brand-black text-brand-black font-semibold tracking-wide hover:bg-brand-black hover:text-white transition">
                    Email Us
                </a>
            </div>
        </div>
    </div>
</body>
</html>
