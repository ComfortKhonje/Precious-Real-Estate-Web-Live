@props(['services' => []])

<section class="py-12 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="mb-8 md:mb-16">
            <div class="badge-yellow">Our Services</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black mb-4">Comprehensive Real Estate Solutions</h2>
            <p class="text-gray-600 text-lg">Professional services grounded in Malawian land laws and international
                valuation standards.</p>
        </div>

        @if ($services->isEmpty())
            <div class="rounded-3xl border border-gray-200 bg-white p-10 text-center">
                <p class="text-gray-600">No services are available right now. Please check back later.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <x-home.service-card title="{{ $service->title }}"
                        description="{{ $service->short_description ?: $service->content }}"
                        icon="{{ $service->icon ?: 'property-valuation.svg' }}"
                        bgImage="{{ $service->banner_image ? asset($service->banner_image) : asset('brand-assets/services-images/property-valuation.jpg') }}"
                        theme="light" />
                @endforeach

                <div
                    class="bg-brand-black rounded-3xl p-10 shadow-lg flex flex-col justify-center items-center text-center h-full hover:-translate-y-2 transition duration-300 relative overflow-hidden group border border-gray-800">
                    <img src="{{ asset('brand-assets/services-images/view-all-services.jpg') }}" alt=""
                        class="absolute inset-0 w-full h-full object-cover z-0 transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-brand-black/90 z-10 backdrop-blur-[2px]"></div>
                    <div class="bg-primary h-16 w-3 absolute top-9 right-0 rounded-l-lg z-30"></div>
                    <div class="relative z-20 w-full">
                        <a href="{{ route('services') }}"
                            class="btn-primary w-fit border border-primary bg-transparent hover:bg-primary hover:text-brand-black transition duration-300 tracking-wider font-semibold">VIEW
                            ALL SERVICES</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
