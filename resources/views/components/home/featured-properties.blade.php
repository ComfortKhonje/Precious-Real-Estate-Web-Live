<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-8">
            <div class="badge-yellow">Available Properties</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black mb-2">Explore Featured Listings</h2>
            <p class="text-gray-600 text-lg">Browse selected properties available for sale and letting.</p>
        </div>

        {{-- Properties Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
            <x-shared.property-card
                image="{{ asset('brand-assets/4 Properties Page/Property image 3.png') }}"
                location="Area 47, Lilongwe"
                price="MWK 1,500,000"
                status="For Rent"
            />
            <x-shared.property-card
                image="{{ asset('brand-assets/4 Properties Page/Property image 2.png') }}"
                location="Blantyre CBD"
                price="MWK 45,000,000"
                status="For Sale"
            />
            <x-shared.property-card
                image="{{ asset('brand-assets/4 Properties Page/Property image 1.png') }}"
                location="Area 10, Lilongwe"
                price="MWK 1,500,000"
                status="For Rent"
            />
        </div>

        {{-- Browse All CTA --}}
        <div class="text-center">
            <a href="{{ route('properties') }}" class="btn-primary px-10 tracking-wider font-semibold hover:scale-[1.03] active:scale-[0.97] transition-all duration-300">BROWSE ALL PROPERTIES</a>
        </div>

    </div>
</section>
