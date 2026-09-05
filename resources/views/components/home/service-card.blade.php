@props([
    'title',
    'description',
    'icon',
    'bgImage' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'theme' => 'light'
])

@php
    $isDark = $theme === 'dark';
    $overlayClass = $isDark ? 'bg-brand-black/80' : 'bg-white/80';
    $titleClass = $isDark ? 'text-white' : 'text-brand-black';
    $descClass = $isDark ? 'text-white/80' : 'text-gray-600';
    $iconBg = $isDark ? 'bg-primary' : 'bg-brand-black';
    $cardBorder = $isDark ? 'border border-gray-800' : 'border border-gray-200';
    $cardShadow = $isDark ? 'shadow-xl shadow-brand-black/20' : 'shadow-sm';
@endphp

<div class="relative rounded-3xl overflow-hidden h-full group transition duration-300 hover:-translate-y-2 flex flex-col {{ $cardBorder }} {{ $cardShadow }}">
    {{-- Background Image --}}
    <img loading="lazy" decoding="async" src="{{ $bgImage }}" alt="" class="absolute inset-0 w-full h-full object-cover z-0 transition duration-700 group-hover:scale-105">

    {{-- Overlay --}}
    <div class="absolute inset-0 {{ $overlayClass }}"></div>

    {{-- Content --}}
    <div class="relative z-20 p-6 md:p-10 flex flex-col h-full">
        <div class="w-16 h-16 rounded-xl {{ $iconBg }} flex items-center justify-center mb-16">
            {{-- Assuming the SVGs have currentColor, but if they are fixed colors we just load them --}}
            <img loading="lazy" decoding="async" src="{{ asset('brand-assets/services-icons/' . $icon) }}" class="w-10 h-10" alt="{{ $title }} Icon">
        </div>

        <div class="mt-auto">
            <h3 class="text-2xl font-bold mb-3 {{ $titleClass }}">{{ $title }}</h3>
            <p class="{{ $descClass }} leading-relaxed">{{ $description }}</p>
        </div>
    </div>

    {{-- Yellow Right Edge Tab --}}
    @if($isDark)
        <div class="bg-primary h-16 w-3 absolute top-9 right-0 rounded-l-lg z-30"></div>
    @else
        <div class="bg-brand-black h-16 w-3 absolute top-9 right-0 rounded-l-lg z-30"></div>
    @endif
</div>
