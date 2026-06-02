<nav id="main-navbar" class="w-full sticky top-0 z-50 bg-transparent border-b border-transparent transition-all duration-300 pt-2 pb-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center nav-logo">
                <a href="{{ route('home') }}" class="transition-transform duration-300 hover:scale-[1.03] active:scale-95 block">
                    <img class="h-16 w-auto" src="{{ asset('brand-assets/1. Logo Suite/2. Primary Logo Lockup/SVG/primary-logo-white-bg.svg') }}" alt="Precious Real Estate Logo">
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-4 items-center h-full">
                <a href="{{ route('home') }}" class="nav-link-item relative h-12 px-2 flex items-center text-sm tracking-wider uppercase transition-all duration-300 {{ request()->routeIs('home') ? 'text-brand-black font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-full after:bg-primary' : 'text-brand-black/70 font-normal hover:text-brand-black hover:font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-0 hover:after:w-full after:bg-primary after:transition-all after:duration-300' }}">Home</a>

                <a href="{{ route('about') }}" class="nav-link-item relative h-12 px-2 flex items-center text-sm tracking-wider uppercase transition-all duration-300 {{ request()->routeIs('about') ? 'text-brand-black font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-full after:bg-primary' : 'text-brand-black/70 font-normal hover:text-brand-black hover:font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-0 hover:after:w-full after:bg-primary after:transition-all after:duration-300' }}">About Us</a>

                {{-- Services Dropdown --}}
                <div class="nav-link-item relative h-12 flex items-center group">
                    <button class="relative h-full px-2 flex items-center text-sm font-normal group-hover:font-semibold tracking-wider uppercase text-brand-black/70 group-hover:text-brand-black transition-all duration-300 focus:outline-none after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-0 group-hover:after:w-full after:bg-primary after:transition-all after:duration-300">
                        Services
                        <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-[100%] left-0 w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-brand-black/5 py-2 mt-0 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-left scale-95 group-hover:scale-100 z-50">
                        <a href="{{ route('services') }}" class="block px-6 py-3 text-sm font-semibold text-brand-black/80 hover:text-brand-black hover:bg-primary/10 transition-colors duration-200">All Services</a>
                        <div class="border-t border-brand-black/5 my-1"></div>
                        <a href="{{ route('services') }}#valuation" class="block px-6 py-2.5 text-xs text-brand-black/70 hover:text-brand-black hover:bg-primary/5 transition-colors duration-200">Property Valuation</a>
                        <a href="{{ route('services') }}#consulting" class="block px-6 py-2.5 text-xs text-brand-black/70 hover:text-brand-black hover:bg-primary/5 transition-colors duration-200">Property Management</a>
                        <a href="{{ route('services') }}#sales-letting" class="block px-6 py-2.5 text-xs text-brand-black/70 hover:text-brand-black hover:bg-primary/5 transition-colors duration-200">Sales & Letting</a>
                        <a href="{{ route('services') }}#development" class="block px-6 py-2.5 text-xs text-brand-black/70 hover:text-brand-black hover:bg-primary/5 transition-colors duration-200">Property Development</a>
                        <a href="{{ route('services') }}#title-deeds" class="block px-6 py-2.5 text-xs text-brand-black/70 hover:text-brand-black hover:bg-primary/5 transition-colors duration-200">Title Deed Services</a>
                    </div>
                </div>

                <a href="{{ route('properties') }}" class="nav-link-item relative h-12 px-2 flex items-center text-sm tracking-wider uppercase transition-all duration-300 {{ request()->routeIs('properties') ? 'text-brand-black font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-full after:bg-primary' : 'text-brand-black/70 font-normal hover:text-brand-black hover:font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-0 hover:after:w-full after:bg-primary after:transition-all after:duration-300' }}">Properties</a>

                <a href="{{ route('updates') }}" class="nav-link-item relative h-12 px-2 flex items-center text-sm tracking-wider uppercase transition-all duration-300 {{ request()->routeIs('updates') ? 'text-brand-black font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-full after:bg-primary' : 'text-brand-black/70 font-normal hover:text-brand-black hover:font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-0 hover:after:w-full after:bg-primary after:transition-all after:duration-300' }}">Updates</a>

                <a href="{{ route('team') }}" class="nav-link-item relative h-12 px-2 flex items-center text-sm tracking-wider uppercase transition-all duration-300 {{ request()->routeIs('team') ? 'text-brand-black font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-full after:bg-primary' : 'text-brand-black/70 font-normal hover:text-brand-black hover:font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-0 hover:after:w-full after:bg-primary after:transition-all after:duration-300' }}">Team</a>

                <a href="{{ route('contact') }}" class="nav-link-item relative h-12 px-2 flex items-center text-sm tracking-wider uppercase transition-all duration-300 {{ request()->routeIs('contact') ? 'text-brand-black font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-full after:bg-primary' : 'text-brand-black/70 font-normal hover:text-brand-black hover:font-semibold after:absolute after:bottom-0 after:left-0 after:h-[3px] after:w-0 hover:after:w-full after:bg-primary after:transition-all after:duration-300' }}">Contact</a>
            </div>

            {{-- Right CTA --}}
            <div class="hidden md:flex items-center nav-cta">
                <a href="{{ route('inquiry') }}" class="btn-primary hover:scale-[1.03] active:scale-[0.97] transition-all duration-300 shadow-sm hover:shadow-md">Make an Inquiry</a>
            </div>

            {{-- Mobile menu button --}}
            <div class="flex items-center md:hidden">
                <button type="button" id="mobile-menu-btn" class="inline-flex items-center justify-center p-2 rounded-full text-brand-black hover:text-primary bg-brand-black/5 hover:bg-brand-black/10 transition-all duration-300 focus:outline-none">
                    <svg id="menu-icon" class="h-6 w-6 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="close-icon" class="h-6 w-6 hidden transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Panel --}}
    <div id="mobile-menu-panel" class="hidden md:hidden border-t border-brand-black/5 bg-white/95 backdrop-blur-lg transition-all duration-300">
        <div class="px-4 pt-4 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-2xl text-base font-semibold tracking-wide uppercase transition-all duration-200 {{ request()->routeIs('home') ? 'bg-primary text-brand-black font-bold' : 'text-brand-black/80 hover:bg-brand-black/5' }}">Home</a>
            <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-2xl text-base font-semibold tracking-wide uppercase transition-all duration-200 {{ request()->routeIs('about') ? 'bg-primary text-brand-black font-bold' : 'text-brand-black/80 hover:bg-brand-black/5' }}">About Us</a>

            {{-- Mobile Services Accordion --}}
            <div class="space-y-1">
                <button type="button" id="mobile-services-toggle" class="w-full flex justify-between items-center px-4 py-2.5 rounded-2xl text-base font-semibold tracking-wide uppercase text-brand-black/80 hover:bg-brand-black/5 transition-all duration-200 focus:outline-none">
                    <span>Services</span>
                    <svg id="mobile-services-arrow" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="mobile-services-submenu" class="hidden pl-6 pr-4 py-2 space-y-2 bg-brand-black/5 rounded-2xl transition-all duration-300">
                    <a href="{{ route('services') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-brand-black/75 hover:text-brand-black hover:bg-brand-black/5 transition-colors">All Services</a>
                    <a href="{{ route('services') }}#valuation" class="block px-4 py-2 rounded-xl text-xs text-brand-black/70 hover:text-brand-black hover:bg-brand-black/5 transition-colors">Property Valuation</a>
                    <a href="{{ route('services') }}#management" class="block px-4 py-2 rounded-xl text-xs text-brand-black/70 hover:text-brand-black hover:bg-brand-black/5 transition-colors">Property Management</a>
                    <a href="{{ route('services') }}#sales-letting" class="block px-4 py-2 rounded-xl text-xs text-brand-black/70 hover:text-brand-black hover:bg-brand-black/5 transition-colors">Sales & Letting</a>
                    <a href="{{ route('services') }}#development" class="block px-4 py-2 rounded-xl text-xs text-brand-black/70 hover:text-brand-black hover:bg-brand-black/5 transition-colors">Property Development</a>
                    <a href="{{ route('services') }}#title-deeds" class="block px-4 py-2 rounded-xl text-xs text-brand-black/70 hover:text-brand-black hover:bg-brand-black/5 transition-colors">Title Deed Services</a>
                </div>
            </div>

            <a href="{{ route('properties') }}" class="block px-4 py-2.5 rounded-2xl text-base font-semibold tracking-wide uppercase transition-all duration-200 {{ request()->routeIs('properties') ? 'bg-primary text-brand-black font-bold' : 'text-brand-black/80 hover:bg-brand-black/5' }}">Properties</a>
            <a href="{{ route('updates') }}" class="block px-4 py-2.5 rounded-2xl text-base font-semibold tracking-wide uppercase transition-all duration-200 {{ request()->routeIs('updates') ? 'bg-primary text-brand-black font-bold' : 'text-brand-black/80 hover:bg-brand-black/5' }}">Updates</a>
            <a href="{{ route('team') }}" class="block px-4 py-2.5 rounded-2xl text-base font-semibold tracking-wide uppercase transition-all duration-200 {{ request()->routeIs('team') ? 'bg-primary text-brand-black font-bold' : 'text-brand-black/80 hover:bg-brand-black/5' }}">Team</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-2xl text-base font-semibold tracking-wide uppercase transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-primary text-brand-black font-bold' : 'text-brand-black/80 hover:bg-brand-black/5' }}">Contact</a>

            <div class="pt-4 border-t border-brand-black/5 mt-4">
                <a href="{{ route('inquiry') }}" class="block w-full text-center py-3.5 px-4 bg-brand-black hover:bg-gray-800 text-primary font-bold uppercase rounded-full tracking-wider text-sm transition-all duration-300 shadow-md">Make an Inquiry</a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.getElementById('main-navbar');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenuPanel = document.getElementById('mobile-menu-panel');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        // Scroll listener to toggle background state
        function handleScroll() {
            if (window.scrollY > 15) {
                // Scrolled State: Frosted glass, drop shadow, compact layout
                navbar.classList.remove('bg-transparent', 'border-transparent', 'py-4');
                navbar.classList.add('bg-white/80', 'backdrop-blur-md', 'border-brand-black/5', 'shadow-sm', 'py-1');
            } else {
                // Top State: Transparent, spacious layout
                navbar.classList.remove('bg-white/80', 'backdrop-blur-md', 'border-brand-black/5', 'shadow-sm', 'py-1');
                navbar.classList.add('bg-transparent', 'border-transparent', 'py-4');
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Trigger initial execution in case the user refreshes mid-scroll

        // Toggle mobile menu panel
        if (mobileMenuBtn && mobileMenuPanel) {
            mobileMenuBtn.addEventListener('click', function () {
                const isHidden = mobileMenuPanel.classList.contains('hidden');
                if (isHidden) {
                    mobileMenuPanel.classList.remove('hidden');
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                } else {
                    mobileMenuPanel.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            });
        }

        // Mobile services toggle accordion
        const mobileServicesToggle = document.getElementById('mobile-services-toggle');
        const mobileServicesSubmenu = document.getElementById('mobile-services-submenu');
        const mobileServicesArrow = document.getElementById('mobile-services-arrow');

        if (mobileServicesToggle && mobileServicesSubmenu) {
            mobileServicesToggle.addEventListener('click', function () {
                const isSubmenuHidden = mobileServicesSubmenu.classList.contains('hidden');
                if (isSubmenuHidden) {
                    mobileServicesSubmenu.classList.remove('hidden');
                    mobileServicesArrow.classList.add('rotate-180');
                } else {
                    mobileServicesSubmenu.classList.add('hidden');
                    mobileServicesArrow.classList.remove('rotate-180');
                }
            });
        }

        // --- GSAP Premium Staggered Load-in Animations with Sleek Delay & FOUC Prevention ---
        if (typeof gsap !== 'undefined') {
            const hasAnimated = sessionStorage.getItem('precious_nav_animated');

            if (hasAnimated) {
                // Instantly display navbar and hero section elements with no animations
                gsap.set('#main-navbar', { y: 0, opacity: 1 });
                gsap.set('.nav-logo', { x: 0, opacity: 1 });
                gsap.set('.nav-link-item', { y: 0, opacity: 1 });
                gsap.set('.nav-cta', { scale: 1, opacity: 1 });

                if (document.querySelector('.animate-hero-title')) {
                    gsap.set('.animate-hero-badge', { scale: 1, opacity: 1 });
                    gsap.set('.animate-hero-title', { y: 0, opacity: 1 });
                    gsap.set('.animate-hero-text', { y: 0, opacity: 1 });
                    gsap.set('.animate-hero-buttons', { y: 0, opacity: 1 });
                    gsap.set('.animate-hero-image', { x: 0, scale: 1, opacity: 1 });
                }
            } else {
                // First visit in session: Set initial invisible/translated states instantly to prevent layout flash
                gsap.set('#main-navbar', { y: -50, opacity: 0 });
                gsap.set('.nav-logo', { x: -30, opacity: 0 });
                gsap.set('.nav-link-item', { y: -20, opacity: 0 });
                gsap.set('.nav-cta', { scale: 0.95, opacity: 0 });

                // Create timeline with 0.5s delay for dynamic premium feel
                const tl = gsap.timeline({
                    delay: 0.5,
                    defaults: { ease: 'power4.out', duration: 1.2 }
                });

                // Animate Navbar elements
                tl.to('#main-navbar', { y: 0, opacity: 1, duration: 1.0 })
                  .to('.nav-logo', { x: 0, opacity: 1, duration: 0.8 }, '-=0.5')
                  .to('.nav-link-item', { y: 0, opacity: 1, stagger: 0.08, duration: 0.7 }, '-=0.6')
                  .to('.nav-cta', { scale: 1, opacity: 1, duration: 0.8 }, '-=0.5');

                // Stagger animate home hero section if it exists on the page
                if (document.querySelector('.animate-hero-title')) {
                    gsap.set('.animate-hero-badge', { scale: 0.85, opacity: 0 });
                    gsap.set('.animate-hero-title', { y: 40, opacity: 0 });
                    gsap.set('.animate-hero-text', { y: 25, opacity: 0 });
                    gsap.set('.animate-hero-buttons', { y: 25, opacity: 0 });
                    gsap.set('.animate-hero-image', { x: 40, scale: 0.98, opacity: 0 });

                    tl.to('.animate-hero-badge', { scale: 1, opacity: 1, duration: 0.6 }, '-=0.5')
                      .to('.animate-hero-title', { y: 0, opacity: 1, duration: 0.9 }, '-=0.5')
                      .to('.animate-hero-text', { y: 0, opacity: 1, duration: 0.8 }, '-=0.6')
                      .to('.animate-hero-buttons', { y: 0, opacity: 1, duration: 0.8 }, '-=0.6')
                      .to('.animate-hero-image', { x: 0, scale: 1, opacity: 1, duration: 1.1 }, '-=0.7');
                }

                // Set key in sessionStorage to skip animations on subsequent page hits
                sessionStorage.setItem('precious_nav_animated', 'true');
            }
        }
    });
</script>
