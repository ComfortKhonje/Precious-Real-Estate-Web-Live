<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="mb-16">
            <div class="badge-yellow">Our Services</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black mb-4">Comprehensive Real Estate Solutions</h2>
            <p class="text-gray-600 text-lg">Professional services grounded in Malawian land laws and international valuation standards.</p>
        </div>

        {{-- Services Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            {{-- Property Valuation (White) --}}
            <x-home.service-card 
                title="Property Valuation" 
                description="Accurate and independent valuations for sales, loans, insurance, and more."
                icon="property-valuation.svg"
                bgImage="{{ asset('brand-assets/services-images/property-valuation.jpg') }}"
                theme="light"
            />

            {{-- Property Management (Dark) --}}
            <x-home.service-card 
                title="Property Management" 
                description="Professional handling of rentals, maintenance, and reporting."
                icon="property-management.svg"
                bgImage="{{ asset('brand-assets/services-images/property-management.jpg') }}"
                theme="dark"
            />

            {{-- Sales & Letting (White) --}}
            <x-home.service-card 
                title="Sales & Letting" 
                description="Fast and reliable property selling and rental services."
                icon="sales-letting.svg"
                bgImage="{{ asset('brand-assets/services-images/sales-letting.jpg') }}"
                theme="light"
            />

            {{-- Property Development (Dark) --}}
            <x-home.service-card 
                title="Property Development" 
                description="From planning to execution, we guide your projects to success."
                icon="property-development.svg"
                bgImage="{{ asset('brand-assets/services-images/property-development.jpg') }}"
                theme="dark"
            />

            {{-- Title Deed Processing (White) --}}
            <x-home.service-card 
                title="Title Deed Processing" 
                description="Secure and reliable assistance in obtaining land ownership documentation."
                icon="title-deed-processing.svg"
                bgImage="{{ asset('brand-assets/services-images/title-deed-processing.jpg') }}"
                theme="light"
            />

            {{-- View All Services (Dark CTA) --}}
            <div class="bg-brand-black rounded-3xl p-10 shadow-lg flex flex-col justify-center items-center text-center h-full hover:-translate-y-2 transition duration-300 relative overflow-hidden group border border-gray-800">
                <img src="{{ asset('brand-assets/services-images/view-all-services.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover z-0 transition duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-brand-black/90 z-10 backdrop-blur-[2px]"></div>
                <div class="bg-primary h-16 w-3 absolute top-9 right-0 rounded-l-lg z-30"></div>
                <div class="relative z-20 w-full">
                    <a href="#" class="btn-primary w-fit border border-primary bg-transparent hover:bg-primary hover:text-brand-black transition duration-300">VIEW ALL SERVICES</a>
                </div>
            </div>

        </div>
    </div>
</section>
