@extends('layouts.app')

@section('title', 'Updates & News - Precious Real Estate')

@section('content')
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-brand-black text-brand-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="{{ asset('brand-assets/website-pages/grid-background.png') }}" alt="Grid" class="w-full h-full object-cover">
        </div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/10 to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-sm font-semibold text-primary tracking-wide mb-6 animate-hero-badge">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                Company Updates
            </div>
            <h1 class="font-heading text-5xl md:text-7xl mb-6 animate-hero-title">Latest <span class="text-primary">News</span></h1>
            <p class="text-xl text-white/70 max-w-2xl mx-auto animate-hero-text">
                Stay updated with the latest trends, market insights, and news from Precious Real Estate.
            </p>
        </div>
    </section>

    {{-- News Grid Section --}}
    <section class="py-24 bg-brand-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(isset($featured))
                {{-- Featured Article --}}
                <div class="mb-20">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-px bg-primary flex-1"></div>
                        <h2 class="font-heading text-3xl text-brand-black tracking-wide uppercase">Featured Story</h2>
                        <div class="h-px bg-primary flex-1"></div>
                    </div>
                    
                    <a href="{{ route('news.show', $featured->id) }}" class="group block relative rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 bg-white border border-gray-100">
                        <div class="flex flex-col lg:flex-row h-full min-h-[400px]">
                            <div class="w-full lg:w-3/5 relative overflow-hidden h-[300px] lg:h-auto">
                                @if($featured->cover_image)
                                    <img src="{{ asset('storage/' . $featured->cover_image) }}" alt="{{ $featured->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="absolute inset-0 w-full h-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent lg:hidden"></div>
                            </div>
                            <div class="w-full lg:w-2/5 p-8 lg:p-12 flex flex-col justify-center relative bg-white">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-10 transition-transform duration-500 group-hover:scale-110"></div>
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="px-3 py-1 bg-primary/20 text-brand-black text-xs font-bold tracking-wider uppercase rounded-full">Featured</span>
                                    <span class="text-sm text-brand-black/50 font-semibold">{{ $featured->published_at ? $featured->published_at->format('M d, Y') : '' }}</span>
                                </div>
                                <h3 class="font-heading text-3xl lg:text-4xl text-brand-black mb-4 group-hover:text-primary transition-colors leading-tight">{{ $featured->title }}</h3>
                                <p class="text-brand-black/70 mb-8 line-clamp-3 lg:line-clamp-4">{{ $featured->summary }}</p>
                                <div class="mt-auto inline-flex items-center text-primary font-semibold tracking-wider uppercase text-sm group-hover:gap-3 transition-all duration-300 gap-2">
                                    Read Article
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            {{-- Grid --}}
            <div class="flex items-center gap-4 mb-10">
                <h2 class="font-heading text-4xl text-brand-black">Latest Articles</h2>
                <div class="h-px bg-gray-200 flex-1 ml-4"></div>
            </div>

            @if($news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($news as $article)
                        @if(!isset($featured) || $article->id !== $featured->id)
                            <a href="{{ route('news.show', $article->id) }}" class="group block bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
                                <div class="relative h-56 overflow-hidden bg-gray-100">
                                    @if($article->cover_image)
                                        <div class="mb-3">
                                            <img src="{{ str_starts_with($article->cover_image, 'http') ? $article->cover_image : asset('storage/' . $article->cover_image . '/medium.webp') }}" class="h-full w-auto rounded-lg object-cover">
                                        </div>
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6 flex-grow flex flex-col">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="text-xs text-brand-black/50 font-bold uppercase tracking-wider">{{ $article->published_at ? $article->published_at->format('M d, Y') : '' }}</span>
                                    </div>
                                    <h3 class="font-heading text-2xl text-brand-black mb-3 group-hover:text-primary transition-colors leading-tight">{{ $article->title }}</h3>
                                    <p class="text-brand-black/60 text-sm mb-6 line-clamp-3">{{ $article->summary }}</p>
                                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-sm font-semibold">
                                        <span class="text-brand-black group-hover:text-primary transition-colors">Read More</span>
                                        <span class="w-8 h-8 rounded-full bg-gray-50 group-hover:bg-primary/20 flex items-center justify-center text-brand-black transition-colors">
                                            <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-16 flex justify-center">
                    {{ $news->links() }}
                </div>
            @else
                @if(!isset($featured))
                    <div class="text-center py-20">
                        <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <h3 class="font-heading text-3xl mb-2">No News Yet</h3>
                        <p class="text-brand-black/60">Check back later for updates and announcements.</p>
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
