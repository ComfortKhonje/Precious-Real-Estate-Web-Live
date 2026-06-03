{{-- [Component: shared/inquiry-footer] Simplified footer for inquiry pages --}}
<footer class="mt-auto w-full relative z-10">
    {{-- Yellow Separator --}}
    <div class="h-1.5 bg-primary w-full"></div>

    {{-- Dark Strip --}}
    <div class="bg-brand-black text-brand-white py-6 px-6 md:px-12">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6 text-[10px] md:text-xs tracking-wider font-xs">

            {{-- Copyright --}}
            <div class="text-gray-400 text-center md:text-left">
                &copy; {{ date('Y') }} Precious Real Estate Consulting (PREC). All rights reserved.
            </div>

            {{-- Links --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('privacy') }}" class="hover:text-primary transition-colors">Privacy Policy</a>
                <span class="text-gray-700">|</span>
                <a href="{{ route('terms') }}" class="hover:text-primary transition-colors">Terms Of Use</a>
                <span class="text-gray-700">|</span>
                <a href="{{ route('credits') }}" class="hover:text-primary transition-colors">Credits</a>
            </div>

            {{-- Powered By --}}
            <div class="text-gray-400">
                Powered By <a href="https://abstractmw.com" target="_blank" class="text-primary font-bold hover:underline transition">Abstract Digital Solutions</a>
            </div>
        </div>
    </div>
</footer>