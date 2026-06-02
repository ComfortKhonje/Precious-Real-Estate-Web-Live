@props(['properties' => []])

<section id="properties-grid" class="pt-72 px-4 md:pt-32 md:pb-12 md:px-6">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header with Sort --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 md:mb-12 gap-2 md:gap-6">
            <div>
                <div class="badge-yellow mb-2 md:mb-4 w-fit px-4 py-1.5 text-xs uppercase tracking-wider">Available
                    Listings</div>
                <h2 class="text-4xl font-heading text-brand-black uppercase">Explore Properties</h2>
            </div>

            <div class="flex items-center gap-4">
                <button
                    class="md:w-fit w-full flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-full text-sm font-bold text-gray-500 hover:bg-gray-50 transition duration-300">
                    <span>Sort</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                    </svg>
                </button>
            </div>
        </div>

        @if ($properties->isEmpty())
            <div class="rounded-3xl border border-gray-200 bg-white p-10 text-center">
                <p class="text-gray-600">No properties are listed yet. Add new properties in the CMS to show them here.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                @foreach ($properties as $property)
                    <x-shared.property-card
                        image="{{ asset($property->media[0] ?? 'brand-assets/4 Properties Page/Property image 1.png') }}"
                        location="{{ $property->location }}"
                        price="{{ number_format($property->price, 0, '.', ',') }} MWK" status="{{ $property->status }}"
                        description="{{ $property->description }}" href="{{ route('property.view', $property->id) }}" />
                @endforeach
            </div>
        @endif

        <div class="text-center">
            <a href="{{ route('properties') }}"
                class="w-full inline-flex justify-center bg-primary text-brand-black rounded-full py-4 px-12 font-bold text-xs uppercase tracking-widest hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-md">View
                All Properties</a>
        </div>
    </div>
</section>
