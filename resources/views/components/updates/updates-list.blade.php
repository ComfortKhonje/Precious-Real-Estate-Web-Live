@php
    $updates = [
        [
            'title' => 'PREC Website Launches Soon',
            'summary' => 'The long awaited website is almost here! We are excited to announce that our new online platform will be launching in the coming weeks, offering a fresh and user-friendly experience for our clients.',
            'category' => 'Announcement',
            'date' => 'Coming soon',
        ],
        [
            'title' => 'Property Market Briefings',
            'summary' => 'We have compiled short market notes, valuation updates, policy notices, and relevant real estate communication.',
            'category' => 'News',
            'date' => 'Coming soon',
        ],
        [
            'title' => 'Service Notices and Company Updates',
            'summary' => 'Office updates, new services, and featured campaigns can live here without changing the core pages of the site.',
            'category' => 'Update',
            'date' => 'Coming soon',
        ],
    ];
@endphp

<section id="updates-list" class="px-6 pb-20">
    <div class="max-w-7xl mx-auto grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="space-y-6">
            @foreach($updates as $update)
                <article class="rounded-[2rem] border border-[#ece8d4] bg-white p-8 shadow-[0_10px_30px_rgba(30,30,30,0.04)]">
                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <span class="inline-flex items-center rounded-full bg-primary/40 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-brand-black">{{ $update['category'] }}</span>
                        <span class="text-sm text-brand-black/45">{{ $update['date'] }}</span>
                    </div>
                    <h2 class="font-heading text-4xl leading-none text-brand-black">{{ $update['title'] }}</h2>
                    <p class="mt-4 text-brand-black/65 text-lg leading-relaxed">{{ $update['summary'] }}</p>
                </article>
            @endforeach
        </div>

        <aside class="rounded-[2rem] border border-[#e6e2cc] bg-[#f4f3ea] p-8 h-fit lg:sticky lg:top-28">
            <h3 class="font-heading text-4xl leading-none text-brand-black">What our announments entail</h3>
            <p class="mt-4 text-brand-black/65 leading-relaxed">Updates about available properties and real estate market conditions in our perspective will be shown here.</p>
            <div class="mt-8 space-y-4">
                <div class="rounded-2xl bg-white p-5 border border-[#ece8d4]">
                    <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50">Industry Trends</p>
                    <p class="mt-2 font-semibold text-brand-black">Get updated on the current state of the real estate market.</p>
                </div>
                <div class="rounded-2xl bg-white p-5 border border-[#ece8d4]">
                    <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50">Available Properties</p>
                    <p class="mt-2 font-semibold text-brand-black">Discover new listings and property updates in your area.</p>
                </div>
            </div>
        </aside>
    </div>
</section>

