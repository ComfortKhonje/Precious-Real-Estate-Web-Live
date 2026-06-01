@php
    $services = [
        [
            'id' => 'valuation',
            'badge' => 'Property Valuation',
            'title' => 'Accurate and Independent Valuations',
            'description' => 'We provide professional property valuation services for a wide range of purposes, ensuring accuracy, compliance, and reliability in every report.',
            'image' => asset('brand-assets/3 Services Page/Image 1.png'),
            'features' => [
                'Buying and selling',
                'Loan security',
                'Insurance purposes',
                'Financial reporting',
                'Dispute resolution',
                'Estate and legal matters'
            ]
        ],
        [
            'id' => 'management',
            'badge' => 'Property Management',
            'title' => 'Reliable Management of Your Property',
            'description' => 'We manage properties with a focus on efficiency, transparency, and consistent performance, ensuring peace of mind for property owners.',
            'image' => asset('brand-assets/3 Services Page/Image 2.png'),
            'features' => [
                'Rent collection',
                'Property maintenance coordination',
                'Bill and statutory payments',
                'Monthly performance reports'
            ]
        ],
        [
            'id' => 'sales-letting',
            'badge' => 'Sales & Letting',
            'title' => 'Efficient Property Sales and Rentals',
            'description' => 'We assist clients in selling and letting properties efficiently, connecting them with the right buyers and tenants within a structured timeframe.',
            'image' => asset('brand-assets/3 Services Page/Image 3.png'),
            'features' => [
                'Fast property turnaround',
                'Market-aligned pricing',
                'Wide property selection',
                'Professional handling of transactions'
            ]
        ],
        [
            'id' => 'development',
            'badge' => 'Property Development',
            'title' => 'From Concept to Completion',
            'description' => 'We provide guidance and support throughout the property development process, ensuring projects are viable, compliant, and well-executed.',
            'image' => asset('brand-assets/3 Services Page/Image 4.png'),
            'features' => [
                'Site identification',
                'Feasibility studies',
                'Project coordination',
                'Development planning'
            ]
        ],
        [
            'id' => 'title-deeds',
            'badge' => 'Title Deed Services',
            'title' => 'Secure Your Property Ownership',
            'description' => 'We assist clients in obtaining title deeds, ensuring proper documentation and legal ownership of property.',
            'image' => asset('brand-assets/3 Services Page/Image 5.png'),
            'features' => [
                'Application guidance',
                'Documentation support',
                'Process navigation',
                'Compliance assistance'
            ]
        ],
    ];
@endphp

<section id="service-details" class="py-16 md:py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            {{-- Sidebar --}}
            <aside class="lg:col-span-3 hidden lg:block">
                <div class="sticky top-32 bg-gray-50 rounded-2xl p-6">
                    <ul class="space-y-2" id="services-sidebar">
                        @foreach($services as $service)
                            <li class="relative">
                                <a href="#{{ $service['id'] }}"
                                   data-service="{{ $service['id'] }}"
                                   class="service-link group flex items-center px-6 py-4 rounded-lg font-semibold transition-all duration-300 border-b-4 border-transparent text-gray-400 hover:text-brand-black hover:bg-gray-100 [&.active]:border-primary [&.active]:text-brand-black">
                                    {{ $service['badge'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- Service List --}}
            <div class="lg:col-span-9 space-y-16 md:space-y-32" id="services-content">
                @foreach($services as $service)
                    <div id="{{ $service['id'] }}" class="service-section grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-10 items-center scroll-mt-32 group">

                        {{-- Image --}}
                        <div class="relative inline-block w-full md:w-fit rounded-[32px] md:rounded-[40px] overflow-hidden bg-gray-800 z-10 border-primary border-2">
                            <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="block w-full md:w-auto h-auto object-contain">
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col">
                            <div class="badge-yellow mb-2 w-fit px-4 py-1.5 text-xs uppercase tracking-wider">{{ $service['badge'] }}</div>
                            <h2 class="text-3xl font-heading text-brand-black mb-2 leading-tight">{{ $service['title'] }}</h2>
                            <p class="text-gray-600 mb-8 leading-relaxed">{{ $service['description'] }}</p>

                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-6">
                                @foreach($service['features'] as $feature)
                                    <li class="flex gap-2 text-md text-gray-700 font-medium items-center">
                                        <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-brand-black flex items-center justify-center">
                                            <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.service-section');
        const navLinks = document.querySelectorAll('.service-link');

        // Set first link as active by default
        if (navLinks.length > 0) {
            navLinks[0].classList.add('active');
        }

        const observerOptions = {
            root: null,
            rootMargin: '-10% 0px -70% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');

                    // Remove active class from all links
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('data-service') === id) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });

        // Smooth scroll on click
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);

                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop - 120, // Adjust for sticky header
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endpush
