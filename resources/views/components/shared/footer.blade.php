<footer id="main-footer" class="bg-brand-black text-brand-white pt-6 md:pt-20 pb-6 md:pb-8 mt-0 relative z-20 overflow-hidden">
    <img src="{{ asset('brand-assets/1 Home Page/Footer background.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-50 pointer-events-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row justify-between gap-8 md:gap-12 mb-4 md:mb-16 items-center lg:items-stretch text-center lg:text-left">

            {{-- Company Info --}}
            <div class="bg-white text-brand-black p-8 rounded-3xl w-full relative flex flex-col items-start">
                <a href="/" class="block mb-6">
                    {{-- Assuming we have a white text/yellow icon version or just use the primary --}}
                    <img class="h-16 md:h-20 w-auto" src="{{ asset('brand-assets/1. Logo Suite/2. Primary Logo Lockup/PNG/primary-logo-yellow-bg.png') }}" alt="Precious Real Estate Logo">
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
                <div class="flex space-x-4">
                    <a href="https://web.facebook.com/p/Precious-Real-Estate-Consulting-100052172436707/" target="_blank" class="bg-brand-black text-white p-3 rounded-xl hover:bg-primary hover:text-brand-black transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
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
