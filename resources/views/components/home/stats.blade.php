<section class="bg-brand-black text-brand-white py-12 border-primary border-t-8 relative overflow-hidden">
    {{-- Desktop Background --}}
    <img src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}" alt="" class="hidden md:block absolute inset-0 w-full h-full object-cover">
    {{-- Mobile Background --}}
    <img src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls mobile.png') }}" alt="" class="block md:hidden absolute inset-0 w-full h-full object-cover">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-4 relative z-10">
            {{-- Stat Item 1 --}}
            <x-home.stat-item icon="registered.svg">
                Registered & Compliant in Malawi
            </x-home.stat-item>

            {{-- Stat Item 2 --}}
            <x-home.stat-item icon="rics-ivs.svg">
                RICS & IVS Guided Standards
            </x-home.stat-item>

            {{-- Stat Item 3 --}}
            <x-home.stat-item icon="serving-public-private.svg">
                Serving Public & Private Sector
            </x-home.stat-item>

            {{-- Stat Item 4 --}}
            <x-home.stat-item icon="since-2016.svg">
                Operational Since <span class="text-primary">2016</span>
            </x-home.stat-item>

        </div>
    </div>
</section>
