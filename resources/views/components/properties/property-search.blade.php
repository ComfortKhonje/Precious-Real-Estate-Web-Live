@props(['initialProperties' => [], 'currentPage' => 1, 'lastPage' => 1])

<section id="properties-search" class="py-8 px-4 md:px-6 bg-gray-50">
    <div class="max-w-7xl mx-auto" x-data="propertySearch({{ json_encode($initialProperties) }}, {{ (int) $currentPage }}, {{ (int) $lastPage }}, {{ Js::from(request()->only(['search', 'location', 'type', 'status', 'min_price', 'max_price', 'currency'])) }})">
        {{-- Results Counter --}}
        {{-- The search/type/status/sort filter bar that used to live here was
             a second, disconnected copy of the hero's server-side filter
             form above (client-side-only, silently out of sync with it) —
             removed 2026-09-08. The hero form is the one real filter UI now;
             this section just shows what it loaded. --}}
        <div class="text-sm text-gray-600 mb-8">
            Showing <strong x-text="allProperties.length"></strong> of <strong x-text="allProperties.length"></strong> loaded properties
        </div>

        {{-- Results Section --}}
        <div x-show="allProperties.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="property in allProperties" :key="property.id">
                <div class="rounded-[1.5rem] md:rounded-[2rem] overflow-hidden shadow-sm bg-brand-white border border-gray-100 flex flex-col hover:shadow-xl transition duration-300 p-2 gap-2 h-fit group">
                    {{-- Image --}}
                    <a :href="`/properties/${property.slug}`" class="h-52 md:h-64 mb-2 relative overflow-hidden rounded-[1.5rem] block">
                        <img loading="lazy" decoding="async" :src="property.featured_image_url" :alt="property.title" class="block absolute inset-0 w-full h-full object-cover pointer-events-none z-0 transition duration-700 group-hover:scale-110">
                    </a>

                    {{-- Content --}}
                    <div class="flex-1 flex flex-col px-2 pb-2">
                        <div class="flex flex-col mb-4">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest" x-text="property.location"></p>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0" :class="property.status === 'For Sale' ? 'bg-brand-black text-white' : 'bg-primary text-brand-black'" x-text="property.status"></span>
                            </div>
                            <h3 class="text-xl font-bold text-brand-black mb-1" x-text="property.title"></h3>
                            <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed h-fit mb-2" x-text="property.description || 'A beautiful property'"></p>
                            <p class="font-heading font-bold text-2xl text-brand-black mt-3" x-text="property.formatted_price"></p>
                        </div>

                        <a :href="`/properties/${property.slug}`" class="mt-auto bg-brand-black text-primary text-center rounded-full py-4 px-6 font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 transition duration-300">
                            VIEW DETAILS
                        </a>
                    </div>
                </div>
            </template>
        </div>

        {{-- Load More --}}
        <div x-show="hasMore" class="text-center mt-10">
            <button
                @click="loadMore()"
                :disabled="loading"
                class="btn-primary px-12 py-4 text-sm tracking-[0.2em] font-bold disabled:opacity-50">
                <span x-text="loading ? 'LOADING...' : 'LOAD MORE PROPERTIES'"></span>
            </button>
        </div>

        {{-- No Results --}}
        <div x-show="allProperties.length === 0" class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <p class="text-gray-600 mb-4">No properties found matching your search criteria.</p>
            <a href="{{ route('properties') }}" class="inline-block bg-primary text-brand-black px-6 py-2 rounded-full font-bold text-sm uppercase hover:scale-105 transition-transform">
                Clear Filters
            </a>
        </div>
    </div>
</section>

<script>
function propertySearch(initialProperties, currentPage, lastPage, activeFilters) {
    return {
        // 2026-09-02 fix: previously received the raw Laravel paginator object
        // here (not a plain array) because the parent view passed $properties
        // directly instead of $properties->items() — spreading a non-iterable
        // object crashed silently and the grid never rendered a single
        // property. Now always a plain array from the start.
        allProperties: initialProperties,
        currentPage: currentPage,
        lastPage: lastPage,
        loading: false,

        get hasMore() {
            return this.currentPage < this.lastPage;
        },

        async loadMore() {
            if (this.loading || !this.hasMore) return;
            this.loading = true;

            try {
                const nextPage = this.currentPage + 1;
                // 2026-09-08 fix: this used to hit /api/properties with only
                // ?page=, so paginating past page 1 on a hero-filtered search
                // (location/type/status/price) silently appended unfiltered
                // results after the filtered first page. Now forwards
                // whatever filters produced the current page.
                // request()->only() always includes every requested key,
                // filled with null for ones absent from the query string —
                // drop those before building the query, or URLSearchParams
                // stringifies them to the literal text "null" and the API
                // ends up filtering for a title containing "null".
                const params = new URLSearchParams({ page: nextPage });
                Object.entries(activeFilters || {}).forEach(([key, value]) => {
                    if (value !== null && value !== undefined && value !== '') {
                        params.set(key, value);
                    }
                });
                const res = await fetch(`/api/properties?${params}`, {
                    headers: { 'Accept': 'application/json' },
                });
                const json = await res.json();

                this.allProperties = this.allProperties.concat(json.data || []);
                this.currentPage = json.current_page || nextPage;
                this.lastPage = json.last_page || this.lastPage;
            } catch (e) {
                console.error('Error loading more properties:', e);
            } finally {
                this.loading = false;
            }
        },
    }
}
</script>
