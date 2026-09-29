@props(['news', 'featured', 'activeCategory' => null, 'categoryCounts' => []])

{{--
    2026-09-08 redesign: was a single continuous two-column layout (stacked
    cards in a left column next to a sticky sidebar the full height of the
    page). Now: a hero row (featured item + filter sidebar, equal height via
    grid `items-stretch` — no JS measurement needed, unlike the properties
    page's overlapping hero card) followed by a full-width 3-column grid for
    the rest. Card styling now varies by category (see x-updates.update-card)
    instead of every card looking identical regardless of Announcement/News/
    Blog.

    2026-09-29 mobile pass: below lg the tall category/contact sidebar sat
    between the featured story and the rest of the feed (a full screen of
    scrolling before the second update). Phones and tablets now get a
    swipeable chip row instead; the contact card is desktop-only (the page
    ends with a contact CTA anyway). Cards become compact feed rows on
    phones — see x-updates.update-card.
--}}
<section id="updates-list" class="px-4 sm:px-6 pb-16 md:pb-20 space-y-8">
    <div class="max-w-7xl mx-auto">

        {{-- Category chips (below lg) --}}
        <nav aria-label="Update categories" class="lg:hidden -mx-4 sm:-mx-6 mb-5">
            <div class="flex gap-2 overflow-x-auto no-scrollbar px-4 sm:px-6 py-1">
                @php $chipTotal = $categoryCounts->sum(); @endphp
                <a href="{{ route('updates') }}" @if(!$activeCategory) aria-current="page" @endif
                    class="shrink-0 inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition-colors {{ !$activeCategory ? 'bg-brand-black text-primary' : 'bg-white text-brand-black border border-[#e6e2cc]' }}">
                    All <span class="text-xs opacity-60">{{ $chipTotal }}</span>
                </a>
                @foreach(\App\Models\Announcement::CATEGORIES as $cat)
                    <a href="{{ route('updates', ['category' => $cat]) }}" @if($activeCategory === $cat) aria-current="page" @endif
                        class="shrink-0 inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition-colors {{ $activeCategory === $cat ? 'bg-brand-black text-primary' : 'bg-white text-brand-black border border-[#e6e2cc]' }}">
                        {{ $cat }} <span class="text-xs opacity-60">{{ $categoryCounts[$cat] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        @if($news->isEmpty())
            <article class="rounded-[1.5rem] md:rounded-[2rem] border border-[#ece8d4] bg-white p-6 md:p-8 shadow-[0_10px_30px_rgba(30,30,30,0.04)] text-center mb-8">
                @if($activeCategory)
                    <h2 class="font-heading text-3xl leading-none text-brand-black mb-2">No {{ $activeCategory }} Updates Yet</h2>
                    <p class="text-brand-black/65 leading-relaxed">Check back later, or <a href="{{ route('updates') }}" class="text-primary font-semibold hover:underline">browse all updates</a>.</p>
                @else
                    <h2 class="font-heading text-3xl leading-none text-brand-black mb-2">No Updates Yet</h2>
                    <p class="text-brand-black/65 leading-relaxed">Check back soon for announcements, news, and posts from our team.</p>
                @endif
            </article>
        @endif

        {{-- Hero row: featured item + sidebar, equal height. Only when there's
             a featured pick (unfiltered view only, per controller) — a
             filtered view has no featured slot to stretch against, so the
             sidebar renders full-width on its own below instead of being
             forced to some arbitrary height with nothing beside it. --}}
        @if($featured)
            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-stretch mb-6 md:mb-8">
                <x-updates.update-card :announcement="$featured" :featured="true" />

                <aside class="hidden lg:block rounded-[2rem] border border-[#e6e2cc] bg-[#f4f3ea] p-8 space-y-8">
                    @include('components.updates.sidebar-content')
                </aside>
            </div>
        @else
            <aside class="hidden lg:block rounded-[2rem] border border-[#e6e2cc] bg-[#f4f3ea] p-8 mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @include('components.updates.sidebar-content')
                </div>
            </aside>
        @endif

        {{-- Regular grid: everything except the featured pick (already shown above) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
            @foreach($news as $update)
                @if(!$featured || $update->id !== $featured->id)
                    <x-updates.update-card :announcement="$update" />
                @endif
            @endforeach
        </div>

        @if($news->hasPages())
            <div class="pt-4">{{ $news->links() }}</div>
        @endif
    </div>
</section>
