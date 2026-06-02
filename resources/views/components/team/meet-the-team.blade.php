@props(['teamMembers' => []])

<section id="team-meet-the-team" class="py-8 md:py-16 px-4 md:px-6">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <div class="badge-yellow">Meet The Team</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black uppercase">Our Professionals</h2>
        </div>

        {{-- Team Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-8">
            @forelse($teamMembers as $member)
                <div class="flex flex-col group">
                    {{-- Member Image --}}
                    <div
                        class="relative aspect-[4/5] rounded-[1rem] md:rounded-[2.5rem] overflow-hidden mb-2 md:mb-4 border-2 md:border-4 border-primary shadow-md">
                        <img src="{{ asset($member->photo_url ?: 'brand-assets/6 Our Team Page/Precious Tembo 1.png') }}"
                            alt="{{ $member->name }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    </div>

                    {{-- Member Info --}}
                    <div class="flex flex-col flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-xl md:text-3xl font-heading text-brand-black leading-tight font-medium">
                                    {{ $member->name }}
                                </h3>
                                <p class="text-sm text-gray-500 uppercase tracking-wider">{{ $member->role }}</p>
                            </div>
                        </div>

                        <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-1">
                            {{ $member->bio ?? 'Our team combines local market expertise with a client-first approach.' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-gray-200 bg-white p-10 text-center col-span-3">
                    <p class="text-gray-600">No team members have been added yet. Please add members in the CMS.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
