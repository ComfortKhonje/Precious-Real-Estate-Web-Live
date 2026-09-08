{{--
    Shared category-filter + contact-card content, reused by both the
    hero-row sidebar (next to the featured card, equal height) and the
    standalone sidebar shown on filtered views where there's no featured
    card to stretch against. Kept as one partial so the two never drift.
--}}
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
