@props(['announcement', 'featured' => false])

@php
    $isAnnouncement = $announcement->category === 'Announcement';
    $isBlog = $announcement->category === 'Blog';
    $imageAspect = $isBlog ? 'aspect-[4/3]' : 'aspect-video';
@endphp

<a href="{{ route('updates.show', $announcement->id) }}"
    class="group flex flex-col h-full rounded-[2rem] overflow-hidden shadow-[0_10px_30px_rgba(30,30,30,0.04)] hover:shadow-lg transition-shadow duration-300 {{ $isAnnouncement ? 'bg-brand-black border border-brand-black' : 'bg-white border border-[#ece8d4]' }}">

    {{-- Cover image — flex-1 so a featured card fills whatever height the sidebar next to it reaches, no JS needed --}}
    <div class="relative w-full overflow-hidden {{ $featured ? 'flex-1 min-h-[220px]' : $imageAspect }}">
        <img loading="lazy" decoding="async" src="{{ $announcement->coverImageUrl('medium') ?: asset('brand-assets/no-image-placeholder.svg') }}" alt="{{ $announcement->title }}"
            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

        @if ($isAnnouncement)
            <div class="absolute inset-0 bg-gradient-to-t from-brand-black via-brand-black/10 to-transparent"></div>
        @endif
    </div>

    <div class="flex flex-col p-6 {{ $featured ? 'md:p-8' : '' }}">
        @if ($isAnnouncement)
            {{-- Bold, urgent tone: badge sits on the image via negative margin so the black card reads as one solid block --}}
            <div class="flex flex-wrap items-center gap-3 mb-3">
                <span class="inline-flex items-center rounded-full bg-primary px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-brand-black">Announcement</span>
                @if ($announcement->is_featured)
                    <span class="inline-flex items-center rounded-full border border-primary/40 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-primary">Featured</span>
                @endif
            </div>
            <h3 class="font-heading {{ $featured ? 'text-4xl' : 'text-2xl' }} leading-tight text-white group-hover:text-primary transition-colors">{{ $announcement->title }}</h3>
            <p class="mt-2 text-white/60 text-xs font-semibold uppercase tracking-wider">{{ $announcement->published_at?->format('M d, Y') }}</p>
            @if ($announcement->summary)
                <p class="mt-4 text-white/70 {{ $featured ? 'text-lg' : 'text-sm' }} leading-relaxed line-clamp-3">{{ $announcement->summary }}</p>
            @endif
        @else
            {{-- Clean/editorial tone shared by News and Blog: date-forward eyebrow line --}}
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center rounded-full bg-primary/40 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-brand-black">{{ $announcement->category ?? 'Update' }}</span>
                <span class="text-xs text-brand-black/45 font-bold uppercase tracking-wider">{{ $announcement->published_at?->format('M d, Y') }}</span>
                @if ($announcement->is_featured)
                    <span class="inline-flex items-center rounded-full bg-brand-black px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-primary">Featured</span>
                @endif
            </div>
            <h3 class="font-heading {{ $featured ? 'text-4xl' : 'text-2xl' }} leading-tight text-brand-black group-hover:text-primary transition-colors">{{ $announcement->title }}</h3>
            @if ($announcement->summary)
                <p class="mt-3 text-brand-black/65 {{ $featured ? 'text-lg' : 'text-sm' }} leading-relaxed line-clamp-3">{{ $announcement->summary }}</p>
            @endif

            @if ($isBlog && $announcement->teamMember)
                <div class="flex items-center gap-3 mt-5 pt-5 border-t border-[#ece8d4]">
                    @if ($announcement->teamMember->photo_url)
                        <img loading="lazy" decoding="async" src="{{ $announcement->teamMember->photo_url }}" alt="{{ $announcement->teamMember->name }}" class="w-9 h-9 rounded-full object-cover shrink-0">
                    @else
                        <div class="w-9 h-9 rounded-full bg-brand-black text-primary flex items-center justify-center text-xs font-bold shrink-0">
                            {{ collect(explode(' ', $announcement->teamMember->name))->map(fn ($p) => mb_substr($p, 0, 1))->join('') }}
                        </div>
                    @endif
                    <div>
                        <p class="text-xs font-bold text-brand-black leading-tight">{{ $announcement->teamMember->name }}</p>
                        <p class="text-[10px] text-brand-black/50 uppercase tracking-wider">{{ $announcement->teamMember->role }}</p>
                    </div>
                </div>
            @endif
        @endif
    </div>
</a>
