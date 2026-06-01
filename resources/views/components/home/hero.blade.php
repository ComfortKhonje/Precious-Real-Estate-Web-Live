<section class="relative min-h-[calc(100svh-6rem)] lg:min-h-[calc(100dvh-5rem)] w-full overflow-hidden flex flex-col lg:flex-row lg:items-center pt-12 lg:pt-0 pb-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-20 lg:flex-grow-0 flex flex-col justify-start lg:justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-2 md:gap-12 items-start lg:items-center">

            {{-- Text Content --}}
            <div class="lg:col-span-7 max-w-2xl z-20 text-center lg:text-left">
                <div class="badge-yellow animate-hero-badge inline-flex mx-auto lg:mx-0">Welcome to Precious Real Estate Consulting</div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading text-brand-black leading-[1.05] mb-4 lg:mb-6 animate-hero-title uppercase tracking-tight">
                    RELIABLE EXPERTISE IN PROPERTY VALUATION & ADVISORY
                </h1>
                <p class="text-base sm:text-lg text-gray-700 mb-6 lg:mb-8 leading-relaxed animate-hero-text max-w-lg mx-auto lg:mx-0">
                    Your professional, trustworthy, and affordable partner in property services across Malawi offering accurate real estate solutions.
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-3 lg:gap-4 animate-hero-buttons">
                    <a href="{{ route('properties') }}" class="btn-primary tracking-wider font-semibold hover:scale-[1.03] active:scale-[0.97] transition-all duration-300 shadow-sm hover:shadow-md py-4 px-10">EXPLORE PROPERTIES</a>
                    <a href="{{ route('inquiry') }}" class="btn-secondary tracking-wider font-semibold hover:scale-[1.03] active:scale-[0.97] transition-all duration-300 shadow-sm hover:shadow-md py-4 px-10">REQUEST CONSULTATION</a>
                </div>
            </div>

            {{-- Spacer for Grid Alignment on Desktop --}}
            <div class="hidden lg:block lg:col-span-5 h-2"></div>
        </div>
    </div>

    {{-- Premium Integrated House Image --}}
    <div class="relative lg:absolute bottom-0 right-0 h-[380px] lg:h-full w-full lg:w-[65%] max-w-[1200px] z-10 pointer-events-none select-none animate-hero-image mt-0">
        {{-- Mobile Image --}}
        <img src="{{ asset('brand-assets/1 Home Page/Hero Section House Image mobile.png') }}" alt="House Image Mobile" class="block lg:hidden absolute bottom-0 right-0 w-full h-full object-contain object-bottom z-10">
        {{-- Desktop Image --}}
        <img src="{{ asset('brand-assets/1 Home Page/Hero Section House Image.png') }}" alt="House Image Desktop" class="hidden lg:block absolute bottom-0 right-0 w-full h-full object-contain object-right-bottom z-10">
    </div>
</section>
