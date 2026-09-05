@extends('layouts.app')

@section('title', $article->title . ' - Precious Real Estate')
@section('meta_description', Str::limit(strip_tags($article->summary ?: $article->content), 155))
@section('meta_type', 'article')
@if ($article->coverImageUrl('large'))
@section('meta_image', $article->coverImageUrl('large'))
@endif

{{--
    2026-09-04: replaces the old news/show.blade.php (dark-hero visual
    language) with Updates' cream/rounded-2rem style, since /news was
    removed and /updates absorbed its functionality.
--}}
@section('content')
    <section class="px-6 pt-32 pb-10 bg-grid">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('updates') }}" class="inline-flex items-center gap-2 text-sm font-semibold tracking-wide text-brand-black/60 hover:text-primary transition-colors mb-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Updates
            </a>

            <div class="flex flex-wrap items-center gap-3 mb-6">
                <span class="inline-flex items-center rounded-full bg-primary/40 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-brand-black">{{ $article->category ?? 'Update' }}</span>
                @if($article->is_featured)
                    <span class="inline-flex items-center rounded-full bg-brand-black px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-primary">Featured</span>
                @endif
                <span class="text-sm text-brand-black/45">{{ $article->published_at?->format('F d, Y') }}</span>
            </div>

            <h1 class="font-heading text-5xl md:text-6xl leading-none text-brand-black mb-10">{{ $article->title }}</h1>

            @if($article->cover_image)
                <div class="relative w-full h-[320px] md:h-[440px] rounded-[2rem] overflow-hidden mb-12 border border-[#ece8d4]">
                    <img loading="lazy" decoding="async" src="{{ $article->coverImageUrl('large') }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="rounded-[2rem] border border-[#ece8d4] bg-white p-8 md:p-12 shadow-[0_10px_30px_rgba(30,30,30,0.04)]">
                <div class="prose prose-lg prose-headings:font-heading prose-headings:text-brand-black prose-p:text-brand-black/75 prose-a:text-primary hover:prose-a:text-primary/80 prose-strong:text-brand-black max-w-none">
                    {!! $article->content !!}
                </div>
            </div>

            @if($article->images->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8">
                    @foreach($article->images as $image)
                        <a href="{{ $image->url('large') }}" target="_blank" rel="noopener" class="block aspect-square rounded-2xl overflow-hidden border border-[#ece8d4]">
                            <img loading="lazy" decoding="async" src="{{ $image->url('medium') }}" alt="{{ $article->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="border-t border-[#ece8d4] mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="font-semibold text-brand-black tracking-wide">Share this update:</p>
                <div class="flex gap-3">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#f4f3ea] hover:bg-primary/40 text-brand-black flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if($recentUpdates->count() > 0)
        <section class="px-6 pb-24">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="font-heading text-4xl text-brand-black">More Updates</h2>
                    <a href="{{ route('updates') }}" class="text-primary font-semibold tracking-wide uppercase hover:text-brand-black transition-colors text-sm">View All</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($recentUpdates as $recent)
                        <a href="{{ route('updates.show', $recent->id) }}" class="group block rounded-[2rem] border border-[#ece8d4] bg-white p-6 shadow-[0_10px_30px_rgba(30,30,30,0.04)] hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center rounded-full bg-primary/40 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-brand-black">{{ $recent->category ?? 'Update' }}</span>
                                <span class="text-xs text-brand-black/45 font-bold uppercase tracking-wider">{{ $recent->published_at?->format('M d, Y') }}</span>
                            </div>
                            <h3 class="font-heading text-2xl text-brand-black mt-2 mb-2 group-hover:text-primary transition-colors leading-tight">{{ $recent->title }}</h3>
                            <p class="text-brand-black/60 text-sm line-clamp-3">{{ $recent->summary }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
