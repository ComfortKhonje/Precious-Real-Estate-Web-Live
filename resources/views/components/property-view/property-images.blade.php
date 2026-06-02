@props(['property'])

<section id="property-images" class="py-16 px-6 bg-brand-white">
    <div class="max-w-7xl mx-auto rounded-3xl bg-complementary p-8">
        @php
            $images = $property->media ?: [];
            $mainImage = $images[0] ?? 'brand-assets/4 Properties Page/Property image 1.png';
            $secondaryImages = array_slice($images, 1, 2);
        @endphp

        <div class="grid gap-6 md:grid-cols-3">
            <div class="h-60 rounded-3xl overflow-hidden bg-brand-black/5">
                <img src="{{ asset($mainImage) }}" alt="{{ $property->title }}" class="object-cover w-full h-full">
            </div>
            <div class="space-y-6">
                @forelse($secondaryImages as $image)
                    <div class="h-28 rounded-3xl overflow-hidden bg-brand-black/5">
                        <img src="{{ asset($image) }}" alt="{{ $property->title }}" class="object-cover w-full h-full">
                    </div>
                @empty
                    <div class="h-28 rounded-3xl bg-brand-black/5"></div>
                    <div class="h-28 rounded-3xl bg-brand-black/5"></div>
                @endforelse
            </div>
        </div>
    </div>
</section>
