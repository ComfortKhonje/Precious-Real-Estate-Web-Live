@php
    $team = [
        [
            'name' => 'PRECIOUS M. S. TEMBO',
            'role' => 'Director & Registered Valuer',
            'qual' => 'BSc Land Management, MSIM',
            'exp' => '11+ Years Experience',
            'desc' => 'Leads the firm\'s valuation and advisory services with extensive experience in property valuation, land management, and real estate consultancy.',
            'image' => asset('brand-assets/6 Our Team Page/Precious Tembo 1.png')
        ],
        [
            'name' => 'RONALD NORRIS MOSOPA',
            'role' => 'Valuation Officer',
            'qual' => 'BSc Estate Management',
            'exp' => '5+ Years Experience',
            'desc' => 'Supports valuation assignments and property assessments with a focus on professionalism and accurate reporting.',
            'image' => asset('brand-assets/6 Our Team Page/Ronald Mosopa, Valuation Officer 1.png')
        ],
        [
            'name' => 'DOREEN MPUNGA',
            'role' => 'Compliance & IT Officer',
            'qual' => 'BSc Information Technology',
            'exp' => '8+ Years Experience',
            'desc' => 'Oversees compliance processes and supports the firm\'s operational and digital systems infrastructure.',
            'image' => asset('brand-assets/6 Our Team Page/Doreen Mpunga, ICT & Compliance Officer. 1.png')
        ],
        [
            'name' => 'HAPPY TEMBO',
            'role' => 'Records Officer',
            'qual' => 'BSc Irrigation Engineering',
            'exp' => '8+ Years Experience',
            'desc' => 'Manages documentation and records processes to support smooth project coordination and information management.',
            'image' => asset('brand-assets/6 Our Team Page/Happy Tembo, Records Officer 1.png')
        ],
        [
            'name' => 'ANDREW MAHUKA',
            'role' => 'Valuation Officer',
            'qual' => 'BSc Land Economy',
            'exp' => '10+ Years Experience',
            'desc' => 'Provides valuation and land economy expertise across residential, commercial, and institutional assignments.',
            'image' => asset('brand-assets/6 Our Team Page/Andrew Mahuka, Valuation Officer  1.png')
        ]
    ];
@endphp

<section id="team-meet-the-team" class="py-8 md:py-16 px-4 md:px-6">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <div class="badge-yellow">Meet The Team</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black uppercase">Our Professionals</h2>
        </div>

        {{-- Team Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-8">
            @foreach($team as $member)
                <div class="flex flex-col group">
                    {{-- Member Image --}}
                    <div class="relative aspect-[4/5] rounded-[1rem] md:rounded-[2.5rem] overflow-hidden mb-2 md:mb-4 border-2 md:border-4 border-primary shadow-md">
                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    </div>

                    {{-- Member Info --}}
                    <div class="flex flex-col flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                @php
                                    $nameParts = explode(' ', $member['name']);
                                    $lastName = array_pop($nameParts);
                                    $firstName = implode(' ', $nameParts);
                                @endphp
                                <h3 class="text-xl md:text-3xl font-heading text-brand-black leading-tight font-medium">
                                    {{ $firstName }} <span class="font-bold">{{ $lastName }}</span>
                                </h3>
                                <p class="text-sm text-gray-500 uppercase tracking-wider">{{ $member['role'] }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between my-2">
                            <span class="text-sm font-bold text-brand-black tracking-widest">{{ $member['qual'] }}</span>
                            <span class="text-xs font-bold text-gray-700 tracking-widest">{{ $member['exp'] }}</span>
                        </div>

                        <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-1">
                            {{ $member['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
