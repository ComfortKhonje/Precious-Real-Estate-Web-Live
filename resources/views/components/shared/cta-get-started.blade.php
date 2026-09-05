{{-- [Component: shared/cta-get-started] "Get Started" CTA band used on multiple pages --}}
<section id="cta-get-started" class="relative pt-8 pb-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Dark CTA Box --}}
        <div class="bg-brand-black rounded-[32px] md:rounded-[40px] border-brand-black border-1 overflow-hidden relative mb-20 shadow-xl min-h-[400px] flex items-stretch">
            <img loading="lazy" decoding="async" src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
            <div class="grid grid-cols-1 lg:grid-cols-2 w-full h-fit">

            <div class="absolute inset-y-0 left-[35%] -translate-x-1/2 w-[40%] bg-gradient-to-l from-[#202020] to-transparent z-0"></div>

                {{-- Text Content --}}
                <div class="p-6 md:p-16 text-white relative z-10 flex flex-col justify-between">
                    <div class="gap-2 md:gap-4">
                        <div class="badge-yellow w-fit">Get Started</div>
                        <h2 class="text-4xl md:text-5xl font-heading mb-2 md:mb-6 uppercase">Ready to Start Your Property Journey?</h2>
                        <p class="text-gray-300 text-lg mb-10 max-w-lg">
                            Speak with our team today for professional guidance tailored to your specific needs.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('inquiry') }}" class="btn-secondary tracking-wider w-full md:w-fit font-semibold hover:scale-[1.03] active:scale-[0.97] transition-all duration-300">START YOUR INQUIRY</a>
                        <a href="{{ route('contact') }}" class="inline-flex w-full md:w-fit items-center justify-center px-8 py-3 bg-transparent text-white border border-white rounded-full font-medium hover:bg-white hover:text-brand-black transition duration-300">CONTACT US</a>
                    </div>
                </div>

                {{-- Image Content --}}
                <div class="relative h-full w-full lg:h-full overflow-hidden">
                        {{-- Desktop Image --}}
                        <img loading="lazy" decoding="async" src="{{ asset('brand-assets/1 Home Page/CTA Image.png') }}" alt="CTA Image" class="hidden lg:block h-full w-full object-cover object-center">
                        {{-- Mobile Image --}}
                        <img loading="lazy" decoding="async" src="{{ asset('brand-assets/1 Home Page/CTA Image mobile.png') }}" alt="CTA Image Mobile" class="block lg:hidden h-full w-full object-cover object-center">
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Info Bar (Yellow) --}}
    <x-shared.contact-info :overlap="true" />
</section>