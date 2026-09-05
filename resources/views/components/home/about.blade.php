<section class="py-8 md:py-24 bg-brand-black text-brand-white relative overflow-hidden border-primary border-t-8">
    <img loading="lazy" decoding="async" src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 md:gap-16 items-center">

            {{-- Image Content --}}
            <div class="relative inline-block w-full md:w-fit rounded-[40px] overflow-hidden bg-gray-800 z-10 border-primary border-2">
                <img loading="lazy" decoding="async"
                    src="{{ asset('brand-assets/1 Home Page/About Section Image.png') }}"
                    alt="About PREC"
                    class="block w-full md:w-auto h-auto object-contain rounded-[40px]"
                >
            </div>

            {{-- Text Content --}}
            <div class="order-1 lg:order-2 z-10">
                <div class="badge-yellow">About PREC</div>
                <h2 class="text-4xl md:text-5xl font-heading text-primary mb-6">A Trusted Name in Property Services</h2>

                <div class="space-y-2 md:space-y-6 text-gray-300 text-lg mb-4 md:mb-10">
                    <p>
                        Precious Real Estate Consulting (PREC) is a registered and professional real estate firm specializing in property valuation, management, and development services.
                    </p>
                    <p>
                        Led by a Registered Valuer and supported by a team of experts, PREC delivers reliable and compliant real estate solutions aligned with national and international standards.
                    </p>
                </div>

                <a href="{{ route('about') }}" class="btn-secondary tracking-wider font-semibold hover:scale-[1.03] active:scale-[0.97] transition-all duration-300">LEARN MORE ABOUT US</a>
            </div>

        </div>
    </div>
</section>
