@props(['property'])

<section id="property-cta" class="py-16 px-6 bg-brand-black text-brand-white">
    <div class="max-w-7xl mx-auto rounded-[2rem] bg-brand-black p-12 text-center">
        <h2 class="font-heading text-3xl">Interested in {{ $property->title }}?</h2>
        <p class="font-body mt-4 text-brand-white/80">Reach out to our team to learn more about this property, schedule a
            viewing, or ask questions about the buying or rental process.</p>
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('inquiry') }}?property_id={{ $property->id }}"
                class="inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black hover:scale-105 transition-transform">
                Make an Inquiry
            </a>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center justify-center rounded-full bg-white/20 border border-white px-6 py-3 text-sm font-semibold text-white hover:bg-white/30 transition-colors">
                Contact Us
            </a>
        </div>
    </div>
</section>
