@extends('layouts.app')

@section('title', $article->title . ' - Precious Real Estate')
@section('meta_description', Str::limit(strip_tags($article->summary ?: $article->content), 155))
@section('meta_type', 'article')
@section('body_class', 'bg-grid-soft')
@if ($article->coverImageUrl('large'))
@section('meta_image', $article->coverImageUrl('large'))
@endif

{{--
    2026-09-04: replaces the old news/show.blade.php (dark-hero visual
    language) with Updates' cream/rounded-2rem style, since /news was
    removed and /updates absorbed its functionality.

    2026-09-08: dropped the bordered white "card" the article text sat in —
    standard editorial pattern is a wider shell for the cover image with a
    narrower plain reading column (~65-75 characters per line) for the text.

    2026-09-29: tightened the gap under the navbar (the nav is sticky and
    already in the page flow, so the old pt-32 doubled it up — every other
    page starts at pt-10/12), centred the reading column instead of leaving
    it hugging the left of a wider shell, added the summary as a standfirst,
    reading time, optional event dates, a softer background grid, and
    Quill-aware body typography (.article-prose in app.css).
--}}
@section('content')
    @php
        $isBlog = $article->category === 'Blog';
        $eventRange = $article->eventDateRange();
        $isMultiDay = $article->event_end_date && ! $article->event_end_date->isSameDay($article->event_start_date);
        $shareUrl = urlencode(request()->url());
        $shareTitle = urlencode($article->title);
    @endphp

    <article class="px-5 sm:px-6 pt-6 md:pt-10 pb-14 md:pb-16">
        <div class="max-w-3xl mx-auto">
            <a href="{{ route('updates') }}" class="group inline-flex items-center gap-2 text-sm font-semibold text-brand-black/60 hover:text-brand-black transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Updates
            </a>

            <header class="mt-6 md:mt-8">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-sm">
                    <span class="inline-flex items-center rounded-full bg-primary/40 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-brand-black">{{ $article->category ?? 'Update' }}</span>
                    @if($article->is_featured)
                        <span class="inline-flex items-center rounded-full bg-brand-black px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-primary">Featured</span>
                    @endif
                    <span class="text-brand-black/50">
                        <time datetime="{{ $article->published_at?->toDateString() }}">{{ $article->published_at?->format('j F Y') }}</time>
                        <span aria-hidden="true" class="mx-1.5">·</span>{{ $article->readingMinutes() }} min read
                    </span>
                </div>

                <h1 class="mt-5 font-heading text-4xl sm:text-5xl md:text-6xl leading-[1.05] text-brand-black text-balance">{{ $article->title }}</h1>

                @if($article->summary)
                    <p class="mt-5 text-lg md:text-xl leading-relaxed text-brand-black/70">{{ $article->summary }}</p>
                @endif

                @if($eventRange || ($isBlog && $article->teamMember))
                    <div class="mt-7 flex flex-wrap items-center gap-x-8 gap-y-4 border-t border-[#ece8d4] pt-6">
                        @if($isBlog && $article->teamMember)
                            <div class="flex items-center gap-3">
                                @if($article->teamMember->photo_url)
                                    <img loading="lazy" decoding="async" src="{{ $article->teamMember->photo_url }}" alt="{{ $article->teamMember->name }}" class="w-11 h-11 rounded-full object-cover shrink-0">
                                @else
                                    <div class="w-11 h-11 rounded-full bg-brand-black text-primary flex items-center justify-center text-sm font-bold shrink-0">
                                        {{ collect(explode(' ', $article->teamMember->name))->map(fn ($p) => mb_substr($p, 0, 1))->join('') }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs text-brand-black/50 uppercase tracking-wider">Posted by</p>
                                    <p class="text-sm font-bold text-brand-black leading-tight">{{ $article->teamMember->name }}<span class="font-normal text-brand-black/60">, {{ $article->teamMember->role }}</span></p>
                                </div>
                            </div>
                        @endif

                        @if($eventRange)
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-primary/30 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-brand-black/50 uppercase tracking-wider">{{ $isMultiDay ? 'Dates' : 'Date' }}</p>
                                    <p class="text-sm font-bold text-brand-black leading-tight">{{ $eventRange }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </header>
        </div>

        @if($article->cover_image)
            <figure class="max-w-5xl mx-auto mt-8 md:mt-10 rounded-2xl md:rounded-[2rem] overflow-hidden border border-[#ece8d4] bg-[#f4f3ea]">
                <img fetchpriority="high" decoding="async" src="{{ $article->coverImageUrl('large') }}" alt="{{ $article->title }}" class="w-full aspect-[16/9] max-h-[560px] object-cover">
            </figure>
        @endif

        <div class="max-w-3xl mx-auto mt-8 md:mt-12">
            @if($isBlog)
                {{-- Gallery photos woven between paragraphs as the reader scrolls
                     instead of dumped in a grid after all the text — see
                     Announcement::interleavedContent(). Photos run a little
                     wider than the text column on larger screens. --}}
                <div class="space-y-10">
                    @foreach($article->interleavedContent() as $block)
                        @if($block['type'] === 'html')
                            <div class="article-prose">{!! $block['value'] !!}</div>
                        @else
                            <figure class="md:-mx-16 rounded-2xl md:rounded-[2rem] overflow-hidden bg-[#f4f3ea]">
                                <img loading="lazy" decoding="async" src="{{ $block['value']->url('large') }}" alt="Photo from {{ $article->title }}" class="w-full aspect-[3/2] object-cover">
                            </figure>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="article-prose">{!! $article->content !!}</div>

                {{-- Announcement/News are short-form by design — not enough
                     reading length to interleave into, so any extra photos
                     get a strip after the content. --}}
                @if($article->images->isNotEmpty())
                    <div class="mt-12">
                        <h2 class="font-heading text-2xl text-brand-black mb-4">Photos</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($article->images as $image)
                                <a href="{{ $image->url('large') }}" target="_blank" rel="noopener" class="group block aspect-square rounded-2xl overflow-hidden bg-[#f4f3ea]">
                                    <img loading="lazy" decoding="async" src="{{ $image->url('medium') }}" alt="Photo from {{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <footer class="mt-12 md:mt-14 border-t border-[#ece8d4] pt-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4" x-data="{ copied: false }">
                <p class="font-semibold text-brand-black">Share this update</p>
                <div class="flex flex-wrap gap-2">
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on WhatsApp" class="w-10 h-10 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook" class="w-10 h-10 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn" class="w-10 h-10 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener noreferrer" aria-label="Share on X" class="w-10 h-10 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <button type="button" x-on:click="navigator.clipboard.writeText(@js(request()->url())).then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                        class="h-10 px-4 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black text-sm font-semibold inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span x-text="copied ? 'Copied' : 'Copy link'">Copy link</span>
                    </button>
                </div>
            </footer>
        </div>
    </article>

    @if($recentUpdates->count() > 0)
        <section class="px-4 sm:px-6 pt-10 md:pt-16 pb-16 md:pb-24 border-t border-[#ece8d4]">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-5 md:mb-8">
                    <h2 class="font-heading text-3xl md:text-4xl text-brand-black">More Updates</h2>
                    <a href="{{ route('updates') }}" class="text-sm font-semibold uppercase tracking-wide text-brand-black/60 hover:text-brand-black transition-colors">View All</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-6">
                    @foreach($recentUpdates as $recent)
                        <x-updates.update-card :announcement="$recent" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
