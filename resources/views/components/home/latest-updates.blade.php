@php
    $updates = [
        [
            'title' => 'Market Insight Reports',
            'summary' => 'Share short updates on property market movement, valuation trends, and client notices from the CMS.',
            'date' => 'Coming soon',
            'tag' => 'News',
        ],
        [
            'title' => 'Client Announcements',
            'summary' => 'Use this section for office updates, service notices, and property campaign announcements.',
            'date' => 'Coming soon',
            'tag' => 'Announcement',
        ],
        [
            'title' => 'Featured Opportunities',
            'summary' => 'Highlight time-sensitive property promotions or important public communication from the PREC team.',
            'date' => 'Coming soon',
            'tag' => 'Update',
        ],
    ];
@endphp

<section id="home-latest-updates" class="py-20 px-6 bg-[#f4f3ea]">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
            <div class="max-w-2xl">
                <span class="badge-yellow">Latest Updates</span>
                <h2 class="font-heading text-5xl text-brand-black leading-none">News, notices, and property updates from PREC.</h2>
                <p class="mt-4 text-brand-black/65 text-lg leading-relaxed">This section gives the CMS announcements a clear frontend destination and keeps clients informed without forcing them into the dashboard.</p>
            </div>
            <a href="{{ route('updates') }}" class="btn-secondary">View All Updates</a>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            @foreach($updates as $item)
                <article class="rounded-[2rem] border border-[#e6e2cc] bg-white p-8 shadow-[0_12px_30px_rgba(30,30,30,0.04)]">
                    <div class="flex items-center justify-between gap-4 mb-8">
                        <span class="inline-flex items-center rounded-full bg-primary/40 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-brand-black">{{ $item['tag'] }}</span>
                        <span class="text-sm text-brand-black/45">{{ $item['date'] }}</span>
                    </div>
                    <h3 class="font-heading text-3xl text-brand-black leading-none">{{ $item['title'] }}</h3>
                    <p class="mt-4 text-brand-black/65 leading-relaxed">{{ $item['summary'] }}</p>
                    <a href="{{ route('updates') }}" class="mt-8 inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.18em] text-brand-black hover:text-brand-black/70 transition">
                        Read More
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-brand-black/10 bg-[#faf9f2]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                            </svg>
                        </span>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

