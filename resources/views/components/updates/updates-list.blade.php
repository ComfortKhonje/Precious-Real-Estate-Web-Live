@props(['news', 'featured', 'activeCategory' => null, 'categoryCounts' => []])

{{--
    2026-09-04: rewritten to run on real Announcement data (published,
    paginated, optional featured pick) instead of three hardcoded
    "Coming soon" placeholder entries. Layout unchanged — this is the
    layout Comfort asked to keep; only the data source and category badges
    (now real, from Announcement::CATEGORIES) changed. Absorbs the old
    /news page's functionality, which is now removed.

    2026-09-05: the sidebar's "what our announcements entail" panel was
    static marketing copy with no function. Replaced with a real category
    filter (ties into the category field added 2026-09-04) and a contact
    card pulling from the same ContactInfo single-source-of-truth used
    site-wide — both genuinely useful to someone reading updates, not
    filler text.
--}}
<section id="updates-list" class="px-6 pb-20 bg-grid">
    <div class="max-w-7xl mx-auto grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="space-y-6">
            @if($news->isEmpty())
                <article class="rounded-[2rem] border border-[#ece8d4] bg-white p-8 shadow-[0_10px_30px_rgba(30,30,30,0.04)] text-center">
                    @if($activeCategory)
                        <h2 class="font-heading text-3xl leading-none text-brand-black mb-2">No {{ $activeCategory }} Updates Yet</h2>
                        <p class="text-brand-black/65 leading-relaxed">Check back later, or <a href="{{ route('updates') }}" class="text-primary font-semibold hover:underline">browse all updates</a>.</p>
                    @else
                        <h2 class="font-heading text-3xl leading-none text-brand-black mb-2">No Updates Yet</h2>
                        <p class="text-brand-black/65 leading-relaxed">Check back soon for announcements, notices, and market updates.</p>
                    @endif
                </article>
            @endif

            @if($featured)
                <a href="{{ route('updates.show', $featured->id) }}" class="group block rounded-[2rem] border border-[#ece8d4] bg-white overflow-hidden shadow-[0_10px_30px_rgba(30,30,30,0.04)] hover:shadow-lg transition-shadow duration-300">
                    @if($featured->cover_image)
                        <div class="h-56 overflow-hidden">
                            <img loading="lazy" decoding="async" src="{{ $featured->coverImageUrl('medium') }}" alt="{{ $featured->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @endif
                    <div class="p-8">
                        <div class="flex flex-wrap items-center gap-3 mb-5">
                            <span class="inline-flex items-center rounded-full bg-brand-black px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-primary">Featured</span>
                            <span class="inline-flex items-center rounded-full bg-primary/40 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-brand-black">{{ $featured->category ?? 'Update' }}</span>
                            <span class="text-sm text-brand-black/45">{{ $featured->published_at?->format('M d, Y') }}</span>
                        </div>
                        <h2 class="font-heading text-4xl leading-none text-brand-black group-hover:text-primary transition-colors">{{ $featured->title }}</h2>
                        <p class="mt-4 text-brand-black/65 text-lg leading-relaxed">{{ $featured->summary }}</p>
                    </div>
                </a>
            @endif

            @foreach($news as $update)
                @if(!$featured || $update->id !== $featured->id)
                    <a href="{{ route('updates.show', $update->id) }}" class="group block rounded-[2rem] border border-[#ece8d4] bg-white p-8 shadow-[0_10px_30px_rgba(30,30,30,0.04)] hover:shadow-lg transition-shadow duration-300">
                        <div class="flex flex-wrap items-center gap-3 mb-5">
                            <span class="inline-flex items-center rounded-full bg-primary/40 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-brand-black">{{ $update->category ?? 'Update' }}</span>
                            <span class="text-sm text-brand-black/45">{{ $update->published_at?->format('M d, Y') }}</span>
                        </div>
                        <h2 class="font-heading text-4xl leading-none text-brand-black group-hover:text-primary transition-colors">{{ $update->title }}</h2>
                        <p class="mt-4 text-brand-black/65 text-lg leading-relaxed">{{ $update->summary }}</p>
                    </a>
                @endif
            @endforeach

            @if($news->hasPages())
                <div class="pt-4">{{ $news->links() }}</div>
            @endif
        </div>

        <aside class="rounded-[2rem] border border-[#e6e2cc] bg-[#f4f3ea] p-8 h-fit lg:sticky lg:top-28 space-y-8">
            {{-- Category filter --}}
            <div>
                <h3 class="font-heading text-2xl leading-none text-brand-black mb-4">Browse by Category</h3>
                <div class="space-y-2">
                    @php $totalCount = $categoryCounts->sum(); @endphp
                    <a href="{{ route('updates') }}" class="flex items-center justify-between px-4 py-3 rounded-xl font-semibold text-sm transition-colors {{ !$activeCategory ? 'bg-brand-black text-primary' : 'bg-white text-brand-black hover:bg-primary/20' }}">
                        <span>All Updates</span>
                        <span class="text-xs opacity-60">{{ $totalCount }}</span>
                    </a>
                    @foreach(\App\Models\Announcement::CATEGORIES as $cat)
                        <a href="{{ route('updates', ['category' => $cat]) }}" class="flex items-center justify-between px-4 py-3 rounded-xl font-semibold text-sm transition-colors {{ $activeCategory === $cat ? 'bg-brand-black text-primary' : 'bg-white text-brand-black hover:bg-primary/20' }}">
                            <span>{{ $cat }}</span>
                            <span class="text-xs opacity-60">{{ $categoryCounts[$cat] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Contact card --}}
            <div class="pt-8 border-t border-[#e6e2cc]">
                <h3 class="font-heading text-2xl leading-none text-brand-black mb-3">Need to Talk to Someone?</h3>
                <p class="text-brand-black/65 leading-relaxed mb-5">Our team is ready to help with valuations, listings, or general enquiries.</p>
                <div class="space-y-3">
                    <a href="tel:{{ \App\Support\ContactInfo::phone() }}" class="flex items-center gap-3 rounded-2xl bg-white p-4 border border-[#ece8d4] hover:border-primary/40 transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-brand-black flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-brand-black/45 font-bold">Call Us</p>
                            <p class="text-sm font-semibold text-brand-black">{{ \App\Support\ContactInfo::phone() }}</p>
                        </div>
                    </a>
                    <a href="{{ route('inquiry') }}" class="btn-primary w-full justify-center text-xs tracking-widest">MAKE AN INQUIRY</a>
                </div>
            </div>
        </aside>
    </div>
</section>
