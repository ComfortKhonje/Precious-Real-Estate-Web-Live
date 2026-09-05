<footer id="main-footer" class="bg-brand-black text-brand-white pt-6 md:pt-20 pb-6 md:pb-8 mt-0 relative z-20 overflow-hidden">
    <img loading="lazy" decoding="async" src="{{ asset('brand-assets/1 Home Page/Footer background.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-50 pointer-events-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row justify-between gap-8 md:gap-12 mb-4 md:mb-16 items-center lg:items-stretch text-center lg:text-left">

            {{-- Company Info --}}
            <div class="bg-white text-brand-black p-8 rounded-3xl w-full relative flex flex-col items-start">
                <a href="/" class="block mb-6">
                    {{-- Assuming we have a white text/yellow icon version or just use the primary --}}
                    <img loading="lazy" decoding="async" class="h-16 md:h-20 w-auto" src="{{ asset('brand-assets/1. Logo Suite/2. Primary Logo Lockup/PNG/primary-logo-yellow-bg.png') }}" alt="Precious Real Estate Logo">
                </a>
                <p class="text-brand-black text-sm leading-relaxed max-w-none text-left">
                    <strong>Precious Real Estate Consulting (PREC)</strong> is a trusted real estate firm providing professional property valuation, management, and advisory services across Malawi.
                </p>
                <div class="bg-primary h-40 w-2 absolute bottom-auto top-1/2 -translate-y-1/2 right-0 rounded-l-lg z-30"></div>
            </div>

            <div class="w-full flex flex-col sm:flex-row gap-12 justify-center lg:justify-start">
                {{-- Company Links --}}
                <div class="w-full flex flex-col items-center lg:items-start">
                    <h3 class="text-primary font-semibold text-xl mb-2">Company</h3>
                    <ul class="flex flex-wrap justify-center lg:flex-col lg:items-start gap-x-6 gap-y-2">
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition whitespace-nowrap">About</a></li>
                        <li><a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition whitespace-nowrap">Services</a></li>
                        <li><a href="{{ route('properties') }}" class="text-gray-400 hover:text-white transition whitespace-nowrap">Properties</a></li>
                        <li><a href="{{ route('updates') }}" class="text-gray-400 hover:text-white transition whitespace-nowrap">Updates</a></li>
                        <li><a href="{{ route('team') }}" class="text-gray-400 hover:text-white transition whitespace-nowrap">Team</a></li>
                        <li><a href="{{ route('inquiry') }}" class="text-gray-400 hover:text-white transition whitespace-nowrap">Inquiry</a></li>
                    </ul>
                </div>

                {{-- Services Links --}}
                <div class="w-full flex flex-col items-center lg:items-start">
                    <h3 class="text-primary font-semibold text-xl mb-2">Services</h3>
                    <ul class="flex flex-wrap justify-center lg:flex-col lg:items-start gap-x-6 gap-y-4">
                        <li><a href="{{ route('services') }}#valuation" class="text-gray-400 hover:text-white transition whitespace-nowrap">Property Valuation</a></li>
                        <li><a href="{{ route('services') }}#management" class="text-gray-400 hover:text-white transition whitespace-nowrap">Property Management</a></li>
                        <li><a href="{{ route('services') }}#sales-letting" class="text-gray-400 hover:text-white transition whitespace-nowrap">Sales & Letting</a></li>
                        <li><a href="{{ route('services') }}#development" class="text-gray-400 hover:text-white transition whitespace-nowrap">Property Development</a></li>
                        <li><a href="{{ route('services') }}#title-deeds" class="text-gray-400 hover:text-white transition whitespace-nowrap">Title Deed Processing</a></li>
                    </ul>
                </div>
            </div>

            {{-- Connect --}}
            <div class="bg-white text-brand-black p-8 rounded-3xl w-full relative flex flex-col items-start">
                <h3 class="font-semibold text-xl mb-4 font-heading">Connect</h3>
                <p class="text-sm text-gray-600 mb-6 max-w-xs lg:max-w-none text-left">Stay updated with our latest property listings and updates.</p>
                @php
                    $facebookUrl = \App\Support\ContactInfo::facebookUrl();
                    $instagramUrl = \App\Support\ContactInfo::instagramUrl();
                    $linkedinUrl = \App\Support\ContactInfo::linkedinUrl();
                    $whatsapp = \App\Support\ContactInfo::whatsapp();
                @endphp
                <div class="flex space-x-4">
                    @if($facebookUrl)
                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="bg-brand-black text-white p-3 rounded-xl hover:bg-primary hover:text-brand-black transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    @endif
                    @if($instagramUrl)
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="bg-brand-black text-white p-3 rounded-xl hover:bg-primary hover:text-brand-black transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.065.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 100 10 5 5 0 000-10zm0 8.25a3.25 3.25 0 110-6.5 3.25 3.25 0 010 6.5zm5.25-8.813a1.313 1.313 0 100-2.626 1.313 1.313 0 000 2.626z"></path>
                        </svg>
                    </a>
                    @endif
                    @if($linkedinUrl)
                    <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener" class="bg-brand-black text-white p-3 rounded-xl hover:bg-primary hover:text-brand-black transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 110-4.124 2.062 2.062 0 010 4.124zM7.114 20.452H3.56V9h3.554v11.452z"></path>
                        </svg>
                    </a>
                    @endif
                    @if($whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" rel="noopener" class="bg-brand-black text-white p-3 rounded-xl hover:bg-primary hover:text-brand-black transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.9 9.9 0 004.74 1.21h.005c5.46 0 9.9-4.45 9.9-9.92 0-2.65-1.03-5.14-2.9-7.01A9.87 9.87 0 0012.04 2zm5.79 14.13c-.24.68-1.4 1.3-1.93 1.38-.49.08-1.11.11-1.8-.11-.41-.13-.95-.31-1.63-.6-2.87-1.24-4.74-4.13-4.89-4.32-.14-.2-1.17-1.55-1.17-2.96 0-1.4.73-2.09 1-2.38.24-.27.53-.33.7-.33h.5c.16 0 .38-.02.58.45.24.57.8 1.97.87 2.12.07.14.11.31.02.5-.08.19-.13.31-.26.48-.13.16-.27.36-.39.48-.13.14-.26.28-.11.55.15.28.68 1.12 1.46 1.82 1 .89 1.85 1.17 2.13 1.3.28.13.44.11.6-.07.16-.18.68-.79.87-1.06.19-.28.37-.23.62-.14.26.1 1.63.77 1.91.91.28.14.47.21.53.33.07.13.07.7-.17 1.37z"></path>
                        </svg>
                    </a>
                    @endif
                </div>
                <div class="bg-primary h-40 w-2 absolute bottom-auto top-1/2 -translate-y-1/2 right-0 rounded-l-lg z-30"></div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-gray-800 pt-4 flex flex-col md:flex-row justify-between items-center text-xs text-brand-white">
            <p class="text-gray-400 text-center">&copy; {{ date('Y') }} Precious Real Estate Consulting (PREC). All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="{{ route('privacy') }}" class="hover:text-primary transition-colors">Privacy Policy</a>
                <span class="text-gray-700">|</span>
                <a href="{{ route('terms') }}" class="hover:text-primary  transition">Terms of Use</a>
                <span class="text-gray-700">|</span>
                <a href="{{ route('credits') }}" class="hover:text-primary transition-colors">Credits</a>
            </div>
            <p class="mt-4 md:mt-0">Powered By <a href="https://abstractmw.com" target="_blank" class="text-primary font-bold hover:underline transition">Abstract Digital Solutions</a></p>
        </div>
    </div>
</footer>
