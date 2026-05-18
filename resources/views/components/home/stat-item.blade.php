@props(['icon'])

<div class="flex flex-col bg-white/10 py-6 px-6 h-fit rounded-lg hover:bg-white/20 transition duration-300 relative">
    <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-brand-black mb-4">
        <img src="{{ asset('brand-assets/stats-icons/' . $icon) }}" class="w-8 h-8" alt="Stat Icon">
    </div>
    <div class="bg-primary h-12 w-2 absolute top-8 right-0 rounded-l-md"></div>
    <h4 class="font-semibold text-lg text-white leading-tight">
        {{ $slot }}
    </h4>
</div>
