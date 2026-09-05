@props(['properties'])

<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="badge-yellow">Available Properties</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black mb-4 uppercase tracking-tight">Explore Featured Listings</h2>
            <p class="text-gray-600 text-lg">Browse selected properties available for sale and letting across Malawi.</p>
        </div>

        {{-- Properties Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 mb-12">
            @foreach($properties as $property)
                <x-shared.property-card
                    :image="$property->featuredImageUrl('medium')"
                    :title="$property->title"
                    :location="$property->location"
                    :price="$property->formatted_price"
                    :type="$property->status === 'For Sale' ? 'Sale' : 'Rent'"
                    :slug="$property->slug"
                    :description="$property->description"
                />
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('properties') }}" class="btn-primary px-12 py-5 text-sm tracking-[0.2em] font-bold shadow-xl hover:scale-105 active:scale-95 transition-all duration-300">BROWSE ALL PROPERTIES</a>
        </div>

    </div>
</section>
