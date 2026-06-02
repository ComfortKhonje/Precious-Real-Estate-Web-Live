@props(['properties' => []])

<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-8">
            <div class="badge-yellow">Available Properties</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black mb-2">Explore Featured Listings</h2>
            <p class="text-gray-600 text-lg">Browse selected properties available for sale and letting.</p>
        </div>

        @if ($properties->isEmpty())
            <div class="rounded-3xl border border-gray-200 bg-white p-10 text-center">
                <p class="text-gray-600">No featured properties are available right now.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
                @foreach ($properties as $property)
                    @php
                        $image = $property->media[0] ?? 'brand-assets/4 Properties Page/Property image 1.png';
                        $imageUrl = str_starts_with($image, 'http') ? $image : asset($image);
                    @endphp
                    <x-shared.property-card image="{{ $imageUrl }}" location="{{ $property->location }}"
                        price="{{ number_format($property->price, 0, '.', ',') }} MWK" status="{{ $property->status }}"
                        description="{{ $property->description }}" href="{{ route('property.view', $property->id) }}" />
                @endforeach
            </div>
        @endif

        <div class="text-center">
            <a href="{{ route('properties') }}"
                class="btn-primary px-10 tracking-wider font-semibold hover:scale-[1.03] active:scale-[0.97] transition-all duration-300">BROWSE
                ALL PROPERTIES</a>
        </div>

    </div>
</section>
