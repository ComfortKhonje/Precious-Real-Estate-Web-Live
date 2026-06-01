{{-- [Component: about/team-preview] Team preview placeholder with profiles --}}
<section id="about-team-preview" class="py-8 md:py-16 px-4 md:px-6">
    <div class="max-w-7xl mx-auto rounded-3xl p-0 md:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-16 items-center">
            {{-- Text Content --}}
            <div class="space-y-6">
                <div class="gap-2">
                    <div class="badge-yellow">Our Team</div>
                    <h2 class="text-4xl md:text-5xl font-heading text-brand-black">Experienced Professionals Behind Our Work</h2>

                    <div class="text-brand-black text-lg">
                        <p>
                            Our team is composed of qualified professionals with diverse expertise in real estate, valuation, and property management, led by a Registered Valuer with extensive industry experience.
                        </p>
                    </div>
                </div>
                <a href="{{ route('team') }}" class="btn-primary tracking-wider font-semiboldhover:scale-[1.03] active:scale-[0.97] transition-all duration-300">MEET OUR TEAM</a>
            </div>

            {{-- Image Content --}}
            <div class="relative inline-block w-full md:w-fit rounded-[32px] md:rounded-[40px] overflow-hidden bg-gray-800 z-10 border-primary border-2">
                <img src="{{ asset('brand-assets/2 About Us Page/Image 5.png') }}" alt="Man looking at papers" class="block w-full md:w-auto h-auto object-contain">
            </div>
        </div>
</section>
