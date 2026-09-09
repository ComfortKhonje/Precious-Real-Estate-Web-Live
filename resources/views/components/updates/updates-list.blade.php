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
--}}
<section id="updates-list" class="px-6 pb-20 space-y-8">
    <div class="max-w-7xl mx-auto">

        @if($news->isEmpty())
            <article class="rounded-[2rem] border border-[#ece8d4] bg-white p-8 shadow-[0_10px_30px_rgba(30,30,30,0.04)] text-center mb-8">
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
            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-stretch mb-8">
                <x-updates.update-card :announcement="$featured" :featured="true" />

                <aside class="rounded-[2rem] border border-[#e6e2cc] bg-[#f4f3ea] p-8 space-y-8">
                    @include('components.updates.sidebar-content')
                </aside>
            </div>
        @else
            <aside class="rounded-[2rem] border border-[#e6e2cc] bg-[#f4f3ea] p-8 mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @include('components.updates.sidebar-content')
                </div>
            </aside>
        @endif

        {{-- Regular grid: everything except the featured pick (already shown above) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
