@props(['property'])

<section id="property-info" class="py-16 px-6 bg-complementary">
    <div class="max-w-7xl mx-auto rounded-3xl bg-brand-white p-10">
        <h1 class="font-heading text-4xl">{{ $property->title }}</h1>
        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <div class="space-y-4">
                <p class="font-body text-brand-black/75">{{ $property->description }}</p>
                <div class="text-sm text-brand-black/70 space-y-2">
                    <p><strong>Location:</strong> {{ $property->location }}</p>
                    <p><strong>Category:</strong> {{ $property->category }}</p>
                    <p><strong>Type:</strong> {{ $property->type }}</p>
                    <p><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                    <p><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                </div>
            </div>
            <div class="rounded-3xl border border-complementary bg-complementary p-6">
                <p class="font-heading text-sm uppercase tracking-[0.3em]">
                    {{ number_format($property->price, 0, '.', ',') }} MWK</p>
                <p class="font-body mt-4 text-brand-black/75">{{ $property->status }}</p>
                <div class="mt-6 space-y-2 text-sm text-brand-black/75">
                    <p><strong>Land Size:</strong> {{ $property->land_size }}</p>
                    <p><strong>Parking:</strong> {{ $property->parking }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
