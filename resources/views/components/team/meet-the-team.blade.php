@props(['teamMembers' => []])

<section id="team-meet-the-team" class="py-8 md:py-16 px-4 md:px-6">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <div class="badge-yellow">Meet The Team</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black uppercase">Our Professionals</h2>
        </div>

        {{-- Team Grid — every card gets identical padding (p-4/md:p-8), so
             every image/content column is the same width with zero per-card
             logic. The earlier version zeroed padding on edge-facing sides
             only, which did make cards flush with the section's outer edge,
             but left edge cards' content sitting much farther from their one
             interior divider than middle cards sit from theirs (0 vs double
             padding) — reads as uneven regardless of how the numbers are
             balanced, since an edge card has no "partner" pushing back
             symmetrically. Simpler and cleaner: pad every card the same, and
             pull the whole grid outward by exactly that padding (negative
             margin, clipped by the wrapper's overflow-hidden) so edge cards'
             content still lands flush with the section boundary — the "zero
             padding" illusion happens at the container level instead of
             needing per-card math. The `+1px` in the right/bottom pull also
             clips the last column/row's own border-r/border-b hairline, same
             as before. Fixed 2026-09-08. --}}
        <div class="overflow-hidden">
            <div class="grid grid-cols-2 lg:grid-cols-3 -ml-4 -mt-4 -mr-[calc(1rem+1px)] -mb-[calc(1rem+1px)] md:-ml-8 md:-mt-8 md:-mr-[calc(2rem+1px)] md:-mb-[calc(2rem+1px)]">
            @forelse($teamMembers as $member)
                @php
                    $nameParts = explode(' ', trim($member->name));
                    $lastName = array_pop($nameParts);
                    $firstNames = implode(' ', $nameParts);
                @endphp
                <div class="flex flex-col group border-r border-b border-gray-200 p-4 md:p-8">
                    {{-- Member Image --}}
                    <div class="relative aspect-[4/5] rounded-[1rem] md:rounded-[2.5rem] overflow-hidden mb-4 md:mb-6 border-2 md:border-4 border-primary shadow-md">
                        <img loading="lazy" decoding="async" src="{{ $member->photoUrl('medium') }}" alt="{{ $member->name }}, {{ $member->role }}" class="h-full w-full object-cover">
                    </div>

                    {{-- Member Info --}}
                    <div class="flex flex-col flex-1">
                        <h3 class="text-xl md:text-3xl font-heading text-brand-black leading-tight">
                            {{ $firstNames }} <strong class="font-bold">{{ $lastName }}</strong>
                        </h3>
                        <p class="text-sm text-gray-500 uppercase tracking-wider mt-1 mb-4">{{ $member->role }}</p>

                        @if($member->qualifications || $member->years_experience)
                            <div class="flex items-start justify-between gap-3 mb-4 pb-4 border-b border-gray-100">
                                <p class="text-sm font-semibold text-brand-black">{{ $member->qualifications }}</p>
                                @if($member->years_experience)
                                    <p class="text-xs text-gray-400 whitespace-nowrap shrink-0">{{ $member->years_experience }} {{ Str::plural('Yr', $member->years_experience) }} Exp.</p>
                                @endif
                            </div>
                        @endif

                        <p class="text-gray-500 text-sm leading-snug flex-1">
                            {{ $member->bio ?? 'Our team combines local market expertise with a client-first approach.' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="border-r border-b border-gray-200 p-10 text-center col-span-2 lg:col-span-3">
                    <p class="text-gray-600">No team members have been added yet. Please add members in the CMS.</p>
                </div>
            @endforelse
            </div>
        </div>
    </div>
</section>
