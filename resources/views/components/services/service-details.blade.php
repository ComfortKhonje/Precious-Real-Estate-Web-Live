@props(['services' => []])

<section id="service-details" class="py-16 md:py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            {{-- Sidebar --}}
            <aside class="lg:col-span-3 hidden lg:block">
                <div class="sticky top-32 bg-gray-50 rounded-2xl p-6">
                    <ul class="space-y-2" id="services-sidebar">
                        @foreach ($services as $service)
                            <li class="relative">
                                <a href="#service-{{ $service->id }}" data-service="service-{{ $service->id }}"
                                    class="service-link group flex items-center px-6 py-4 rounded-lg font-semibold transition-all duration-300 border-b-4 border-transparent text-gray-400 hover:text-brand-black hover:bg-gray-100 [&.active]:border-primary [&.active]:text-brand-black">
                                    {{ $service->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- Service List --}}
            <div class="lg:col-span-9 space-y-16 md:space-y-32" id="services-content">
                @foreach ($services as $service)
                    <div id="service-{{ $service->id }}"
                        class="service-section grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-10 items-center scroll-mt-32 group">

                        {{-- Image --}}
                        <div
                            class="relative inline-block w-full md:w-fit rounded-[32px] md:rounded-[40px] overflow-hidden bg-gray-800 z-10 border-primary border-2">
                            @if ($service->banner_image)
                                <img src="{{ asset($service->banner_image) }}" alt="{{ $service->title }}"
                                    class="block w-full md:w-auto h-auto object-contain">
                            @else
                                <div class="block w-full h-full bg-gray-200"></div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col">
                            <div class="badge-yellow mb-2 w-fit px-4 py-1.5 text-xs uppercase tracking-wider">
                                {{ $service->title }}</div>
                            <h2 class="text-3xl font-heading text-brand-black mb-2 leading-tight">{{ $service->title }}
                            </h2>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                {{ $service->short_description ?: $service->content }}</p>

                            @if ($service->content)
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-6">
                                    @foreach (explode("\n", strip_tags($service->content)) as $feature)
                                        @if (trim($feature))
                                            <li class="flex gap-2 text-md text-gray-700 font-medium items-center">
                                                <div
                                                    class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-brand-black flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-primary" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <span>{{ trim($feature) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
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

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);

                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - 120,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
@endpush
