{{--
    2026-09-29: mobile pass. The 60px heading overflowed a phone screen
    ("announcements" ran off the edge) and the hero filled the whole first
    screen. Phones now get a compact masthead; md and up are unchanged.
--}}
<section id="updates-page-hero" class="px-4 sm:px-6 pt-4 pb-4 sm:pt-8 md:pt-12 md:pb-10">
    <div class="max-w-7xl mx-auto rounded-[1.5rem] md:rounded-[2rem] bg-brand-black text-white overflow-hidden relative px-6 py-8 sm:px-8 sm:py-12 md:px-12 md:py-16">
        <img src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center rounded-full bg-primary px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-semibold uppercase tracking-[0.2em] text-brand-black">Updates & News</span>
            <h1 class="mt-4 md:mt-5 font-heading text-[2.5rem] sm:text-5xl md:text-6xl leading-[0.95] md:leading-none text-balance">Public announcements, notices, and market updates.</h1>
            <p class="mt-3 md:mt-5 text-[15px] md:text-lg leading-relaxed text-white/75">Stay up to date with company announcements, property market notices, and news from Precious Real Estate Consulting.</p>
        </div>
    </div>
</section>
