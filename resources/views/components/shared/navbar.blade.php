<nav class="w-full sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 items-center">
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="/">
                    <img class="h-20 w-auto" src="{{ asset('brand-assets/1. Logo Suite/2. Primary Logo Lockup/SVG/primary-logo-white-bg.svg') }}" alt="Precious Real Estate Logo">
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-8 items-center">
                <a href="/" class="text-brand-black hover:text-primary px-1 py-2 text-sm font-semibold tracking-wider uppercase border-b-2 border-primary">Home</a>
                <a href="#" class="text-brand-black hover:text-primary px-1 py-2 text-sm font-semibold tracking-wider uppercase border-b-2 border-transparent">About Us</a>
                
                {{-- Services Dropdown (Simple version for now) --}}
                <div class="relative group">
                    <button class="text-brand-black hover:text-primary px-1 py-2 text-sm font-semibold tracking-wider uppercase border-b-2 border-transparent flex items-center">
                        Services
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>

                <a href="#" class="text-brand-black hover:text-primary px-1 py-2 text-sm font-semibold tracking-wider uppercase border-b-2 border-transparent">Properties</a>
                <a href="#" class="text-brand-black hover:text-primary px-1 py-2 text-sm font-semibold tracking-wider uppercase border-b-2 border-transparent">Team</a>
                <a href="#" class="text-brand-black hover:text-primary px-1 py-2 text-sm font-semibold tracking-wider uppercase border-b-2 border-transparent">Contact</a>
            </div>

            {{-- Right CTA --}}
            <div class="hidden md:flex items-center">
                <a href="#" class="btn-primary">Make an Inquiry</a>
            </div>

            {{-- Mobile menu button --}}
            <div class="flex items-center md:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-brand-black hover:text-primary focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
