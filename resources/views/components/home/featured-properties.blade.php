@props(['properties'])

<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="badge-yellow">Available Properties</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black mb-4 uppercase tracking-tight">Explore <br><span class="text-gray-400">Featured Listings</span></h2>
            <p class="text-gray-600 text-lg">Browse selected properties available for sale and letting across Malawi.</p>
        </div>

        {{-- Properties Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12 mb-16">
            @foreach($properties as $property)
                <x-shared.property-card
                    :image="asset($property->featured_image)"
                    :title="$property->title"
                    :location="$property->location"
                    :price="$property->formatted_price . ($property->status === 'For Rent' ? ' / month' : '')"
                    :type="$property->status === 'For Sale' ? 'Sale' : 'Rent'"
                    :slug="$property->slug"
                    :description="$property->description"
                />
            @endforeach
        </div>

        {{-- Browse All CTA --}}
        <div class="text-center">
            <a href="{{ route('properties') }}" class="btn-primary px-12 py-5 text-sm tracking-[0.2em] font-bold shadow-xl hover:scale-105 active:scale-95 transition-all duration-300">BROWSE ALL PROPERTIES</a>
        </div>

    </div>
</section>
