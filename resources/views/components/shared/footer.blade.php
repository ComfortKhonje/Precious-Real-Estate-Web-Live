<footer class="bg-brand-black text-brand-white pt-20 pb-8 mt-20 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            {{-- Company Info --}}
            <div class="col-span-1 md:col-span-1">
                <a href="/" class="block mb-6">
                    {{-- Assuming we have a white text/yellow icon version or just use the primary --}}
                    <img class="h-12 w-auto brightness-0 invert" src="{{ asset('brand-assets/1. Logo Suite/2. Primary Logo Lockup/SVG/primary-logo-white-bg.svg') }}" alt="Precious Real Estate Logo">
                </a>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Precious Real Estate Consulting (PREC) is a trusted real estate firm providing professional property valuation, management, and advisory services across Malawi.
                </p>
            </div>

            {{-- Company Links --}}
            <div>
                <h3 class="text-primary font-semibold text-lg mb-6">Company</h3>
                <ul class="space-y-4">
                    <li><a href="#" class="text-gray-400 hover:text-white transition">About</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Services</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Properties</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Team</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Inquiry</a></li>
                </ul>
            </div>

            {{-- Services Links --}}
            <div>
                <h3 class="text-primary font-semibold text-lg mb-6">Services</h3>
                <ul class="space-y-4">
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Property Valuation</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Property Management</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Sales & Letting</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Property Development</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Title Deed Processing</a></li>
                </ul>
            </div>

            {{-- Connect --}}
            <div class="bg-white text-brand-black p-8 rounded-2xl">
                <h3 class="font-semibold text-xl mb-4 font-heading">Connect</h3>
                <p class="text-sm text-gray-600 mb-6">Stay updated with our latest property listings and updates.</p>
                <div class="flex space-x-4">
                    <a href="#" class="bg-brand-black text-white p-3 rounded-full hover:bg-primary hover:text-brand-black transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} Precious Real Estate Consulting (PREC). All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Use</a>
                <a href="#" class="hover:text-white transition">Credits</a>
            </div>
        </div>
    </div>
</footer>
