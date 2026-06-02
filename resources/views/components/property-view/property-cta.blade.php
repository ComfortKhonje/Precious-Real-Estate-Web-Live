@props(['property'])

<section id="property-cta" class="py-16 px-6 bg-brand-black text-brand-white">
    <div class="max-w-7xl mx-auto rounded-[2rem] bg-brand-black p-12 text-center">
        <h2 class="font-heading text-3xl">Interested in {{ $property->title }}?</h2>
        <p class="font-body mt-4 text-brand-white/80">Reach out to our team to learn more about this property, schedule a
            viewing, or ask questions about the buying or rental process.</p>
        <a href="{{ route('contact') }}"
            class="mt-8 inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black">Contact
            Us</a>
    </div>
</section>
