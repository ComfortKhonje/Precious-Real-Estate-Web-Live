{{-- [Component: properties/page-hero] Redesigned Properties page hero --}}
<section id="properties-page-hero" class="relative min-h-[calc(100svh-4rem)] lg:min-h-[calc(100vh-5rem)] w-full overflow-visible flex flex-col justify-center bg-brand-black">
    {{-- Background Swirl Overlay --}}
    <img src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}" alt="" class="hidden lg:block absolute inset-0 w-full h-full object-cover pointer-events-none z-0">
    <img src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls mobile.png') }}" alt="" class="block lg:hidden absolute inset-0 w-full h-full object-cover pointer-events-none z-0">

    <div class="w-full relative z-10 flex-1 flex items-stretch border-primary border-b-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 w-full items-stretch">

            {{-- Left Section: Text --}}
            <div class="flex flex-col py-12 md:py-20 relative md:justify-center h-fit md:h-full">
                <div class="mx-auto lg:ml-auto lg:mr-0 px-4 sm:px-6 lg:px-8 w-full max-w-2xl text-center lg:text-left">
                    <div class="text-white">
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-heading leading-tight mb-2 md:mb-6 uppercase tracking-tight">
                            Find the <br><span class="text-primary">Right Property</span>
                        </h1>
                        <p class="text-gray-400 text-lg max-w-md mx-auto lg:mx-0 font-medium">
                            Browse available properties for sale and letting across Malawi. Professional expertise at your service.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Section: Image (Desktop only) --}}
            <div class="relative hidden lg:block border-primary border-l-4">
                <div class="absolute inset-0 w-full h-full">
                    <img src="{{ asset('brand-assets/4 Properties Page/Hero Image.png') }}" alt="Featured Property" class="w-full h-full object-cover">
                    {{-- Subtle Gradient Overlay to blend with dark left --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-black via-transparent to-transparent opacity-40"></div>
                </div>
            </div>

            {{-- Mobile Background Image (Full width) --}}
            <div class="inset-0 w-full h-[50vh] lg:hidden z-0 border-primary border-t-4 overflow-clip">
                <img src="{{ asset('brand-assets/4 Properties Page/Hero Image.png') }}" alt="Featured Property" class="block w-full md:w-auto h-auto object-contain">
                <div class="absolute inset-0 bg-gradient-to-t via-brand-black/30 to-transparent"></div>
            </div>

        </div>
    </div>

    {{-- Search Filter Card: Half overlaying --}}
    <div id="properties-hero-search-card" class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-[90%] md:w-full max-w-7xl z-50">
        <div class="bg-white rounded-[1.5rem] md:rounded-[2rem] py-5 px-4 md:py-8 md:px-6 shadow-xl border border-gray-100 w-full">
            <form action="{{ route('properties') }}" method="GET" class="flex flex-col lg:flex-row gap-6 lg:gap-4 items-stretch lg:items-center w-full">
                {{-- Search (by title) --}}
                <div class="w-full">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or keywords" class="w-full bg-gray-100 border-none px-5 py-4 rounded-xl focus:ring-2 focus:ring-primary text-brand-black font-semibold text-md">
                </div>

                {{-- Location --}}
                <div class="w-full">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Location</label>
                    <select name="location" class="select-popup w-full bg-gray-100 border-none px-5 py-4 rounded-xl focus:ring-2 focus:ring-primary text-brand-black font-semibold text-md cursor-pointer appearance-none bg-[length:16px_16px] bg-[right_1.25rem_center] bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                        <option value="">Select Location</option>
                        {{-- Cities pulled from actual listings (Property::cities()) instead of a
                             hardcoded Lilongwe/Blantyre/Mzuzu/Zomba list — Mzuzu and Zomba had no
                             listings (dead options, always returned empty) and Salima had a
                             listing with no matching option at all. Fixed 2026-09-08. --}}
                        @foreach (\App\Models\Property::cities() as $city)
                            <option value="{{ $city }}" {{ request('location') === $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Property Type --}}
                <div class="w-full">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Property Type</label>
                    {{-- Was a free-text input, out of step with the fixed Property::TYPES
                         dropdown used everywhere else (CMS included) — a typo or unrecognized
                         value here silently matched nothing. Fixed 2026-09-08. --}}
                    <select name="type" class="select-popup w-full bg-gray-100 border-none px-5 py-4 rounded-xl focus:ring-2 focus:ring-primary text-brand-black font-semibold text-md cursor-pointer appearance-none bg-[length:16px_16px] bg-[right_1.25rem_center] bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                        <option value="">All Types</option>
                        @foreach (\App\Models\Property::TYPES as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="w-full">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Status</label>
                    <select name="status" class="select-popup w-full bg-gray-100 border-none px-5 py-4 rounded-xl focus:ring-2 focus:ring-primary font-semibold text-brand-black text-md cursor-pointer appearance-none bg-[length:16px_16px] bg-[right_1.25rem_center] bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                        <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>Any Status</option>
                        <option value="For Sale" {{ request('status') === 'For Sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="For Rent" {{ request('status') === 'For Rent' ? 'selected' : '' }}>For Rent</option>
                    </select>
                </div>

                {{-- Price Range --}}
                {{-- Listings are priced in MWK or USD on completely different numeric
                     scales — the old dropdowns only offered MWK-scale labels (K 200K...K 20M+)
                     compared against the raw price column regardless of currency, so any USD
                     listing (all far smaller numbers, e.g. $15,000) got silently excluded by
                     almost any price filter. Now a currency toggle swaps in the matching
                     option set, and the selected currency submits alongside the range so the
                     backend only ever compares prices within one currency. Fixed 2026-09-08. --}}
                <div class="w-full" x-data="{ currency: {{ Js::from(request('currency') === 'USD' ? 'USD' : 'MWK') }} }">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400">Price Range</label>
                        <div class="flex items-center gap-0.5 bg-gray-100 rounded-full p-0.5">
                            <button type="button" @click="currency = 'MWK'"
                                :class="currency === 'MWK' ? 'bg-brand-black text-primary' : 'text-gray-400'"
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition">MWK</button>
                            <button type="button" @click="currency = 'USD'"
                                :class="currency === 'USD' ? 'bg-brand-black text-primary' : 'text-gray-400'"
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition">USD</button>
                        </div>
                    </div>
                    <input type="hidden" name="currency" :value="currency">
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <select name="min_price" x-show="currency === 'MWK'" x-cloak :disabled="currency !== 'MWK'" class="select-popup w-full bg-gray-100 border-none px-4 py-4 rounded-xl focus:ring-2 focus:ring-primary font-semibold text-brand-black text-md cursor-pointer appearance-none bg-[length:14px_14px] bg-[right_0.75rem_center] bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2214%22 height=%2214%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                <option value="">Min</option>
                                <option value="K 200K" {{ request('min_price') === 'K 200K' ? 'selected' : '' }}>K 200K</option>
                                <option value="K 500K" {{ request('min_price') === 'K 500K' ? 'selected' : '' }}>K 500K</option>
                                <option value="K 1M" {{ request('min_price') === 'K 1M' ? 'selected' : '' }}>K 1M</option>
                            </select>
                            <select name="min_price" x-show="currency === 'USD'" x-cloak :disabled="currency !== 'USD'" class="select-popup w-full bg-gray-100 border-none px-4 py-4 rounded-xl focus:ring-2 focus:ring-primary font-semibold text-brand-black text-md cursor-pointer appearance-none bg-[length:14px_14px] bg-[right_0.75rem_center] bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2214%22 height=%2214%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                <option value="">Min</option>
                                <option value="$1K" {{ request('min_price') === '$1K' ? 'selected' : '' }}>$1K</option>
                                <option value="$5K" {{ request('min_price') === '$5K' ? 'selected' : '' }}>$5K</option>
                                <option value="$10K" {{ request('min_price') === '$10K' ? 'selected' : '' }}>$10K</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="max_price" x-show="currency === 'MWK'" x-cloak :disabled="currency !== 'MWK'" class="select-popup w-full bg-gray-100 border-none px-4 py-4 rounded-xl focus:ring-2 focus:ring-primary font-semibold text-brand-black text-md cursor-pointer appearance-none bg-[length:14px_14px] bg-[right_0.75rem_center] bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2214%22 height=%2214%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                <option value="">Max</option>
                                <option value="K 1M" {{ request('max_price') === 'K 1M' ? 'selected' : '' }}>K 1M</option>
                                <option value="K 20M" {{ request('max_price') === 'K 20M' ? 'selected' : '' }}>K 20M</option>
                                <option value="K 20M+" {{ request('max_price') === 'K 20M+' ? 'selected' : '' }}>K 20M+</option>
                            </select>
                            <select name="max_price" x-show="currency === 'USD'" x-cloak :disabled="currency !== 'USD'" class="select-popup w-full bg-gray-100 border-none px-4 py-4 rounded-xl focus:ring-2 focus:ring-primary font-semibold text-brand-black text-md cursor-pointer appearance-none bg-[length:14px_14px] bg-[right_0.75rem_center] bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2214%22 height=%2214%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                <option value="">Max</option>
                                <option value="$5K" {{ request('max_price') === '$5K' ? 'selected' : '' }}>$5K</option>
                                <option value="$10K" {{ request('max_price') === '$10K' ? 'selected' : '' }}>$10K</option>
                                <option value="$20K+" {{ request('max_price') === '$20K+' ? 'selected' : '' }}>$20K+</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Search Button --}}
                <div class="w-full lg:w-auto lg:self-end">
                    <button type="submit" class="w-full bg-brand-black text-primary rounded-full py-5 px-10 font-bold text-sm uppercase tracking-widest hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-xl">
                        SEARCH
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
