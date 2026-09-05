@props([
    'overlap' => false,
    'variant' => 'yellow'
])

@php
    $isDark = $variant === 'dark';
    $bgClass = $isDark ? null : 'bg-primary';
    $headingClass = $isDark ? 'text-primary' : 'text-brand-black';
    $textClass = $isDark ? 'text-primary' : 'text-brand-black';
    $iconBgClass = $isDark ? 'bg-primary' : 'bg-brand-black';
    $iconColorClass = $isDark ? 'text-brand-black' : 'text-primary';
    $bgImage = $isDark ? null : 'Yellow patter bg.png';
    $bgImageMobile = $isDark ? null : 'Yellow patter bg mobile.png';
@endphp

<div class="{{ $bgClass }} pt-10 md:pt-12 pb-8 relative overflow-visible">
    @if($bgImage)
        {{-- Desktop Background --}}
        <img loading="lazy" decoding="async" src="{{ asset('brand-assets/Backgrounds/' . $bgImage) }}" alt="" class="hidden md:block absolute inset-0 w-full h-full object-cover pointer-events-none">
        {{-- Mobile Background --}}
        <img loading="lazy" decoding="async" src="{{ asset('brand-assets/Backgrounds/' . $bgImageMobile) }}" alt="" class="block md:hidden absolute inset-0 w-full h-full object-cover pointer-events-none">
    @endif
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-4 relative z-20 {{ $overlap ? '-mt-24 md:-mt-24' : '' }}">

            {{-- Phone --}}
            <div class="flex flex-col items-center text-center px-4 pt-0">
                <div class="w-16 h-16 {{ $iconBgClass }} rounded-2xl flex items-center justify-center mb-4 {{ $iconColorClass }} shadow-lg transform transition hover:scale-110">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <h3 class="text-2xl font-heading {{ $headingClass }} mb-2 uppercase">Phone</h3>
                <p class="{{ $textClass }} text-lg font-medium">{{ \App\Support\ContactInfo::phone() }}</p>
            </div>

            {{-- Email --}}
            <div class="flex flex-col items-center text-center px-4 pt-8 md:pt-0">
                <div class="w-16 h-16 {{ $iconBgClass }} rounded-2xl flex items-center justify-center mb-4 {{ $iconColorClass }} shadow-lg transform transition hover:scale-110">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-2xl font-heading {{ $headingClass }} mb-2 uppercase">Email</h3>
                <p class="{{ $textClass }} text-lg font-medium">{{ \App\Support\ContactInfo::email() }}</p>
            </div>

            {{-- Locations --}}
            <div class="flex flex-col items-center text-center pt-8 md:pt-0">
                <div class="w-16 h-16 {{ $iconBgClass }} rounded-2xl flex items-center justify-center mb-4 {{ $iconColorClass }} shadow-lg transform transition hover:scale-110">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-heading {{ $headingClass }} mb-2 uppercase">Locations</h3>
                <p class="{{ $textClass }} text-lg max-w-[300px] leading-snug">
                    {{ \App\Support\ContactInfo::addressLilongwe() }}, <span class="font-bold">Lilongwe</span>,<br>
                    {{ \App\Support\ContactInfo::addressBlantyre() }}, <span class="font-bold">Blantyre</span>
                </p>
            </div>

        </div>
    </div>
</div>
