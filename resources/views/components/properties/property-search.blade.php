@props(['initialProperties' => [], 'currentPage' => 1, 'lastPage' => 1])

<section id="properties-search" class="py-8 px-4 md:px-6 bg-gray-50">
    <div class="max-w-7xl mx-auto" x-data="propertySearch({{ json_encode($initialProperties) }}, {{ (int) $currentPage }}, {{ (int) $lastPage }})">
        {{-- Search & Filter Bar --}}
        <div class="space-y-4 mb-8">
            {{-- Search Input --}}
            <div class="flex flex-col md:flex-row gap-4">
                <input
                    type="text"
                    x-model="searchQuery"
                    @input="filterProperties()"
                    placeholder="Search by title, location or description..."
                    class="flex-1 bg-white rounded-xl py-3 px-4 text-brand-black border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">

                {{-- Type Filter --}}
                <select
                    x-model="filterType"
                    @change="filterProperties()"
                    class="bg-white rounded-xl py-3 px-4 text-brand-black border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer">
                    <option value="">All Types</option>
                    @foreach(\App\Models\Property::TYPES as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>

                {{-- Status Filter --}}
                <select
                    x-model="filterStatus"
                    @change="filterProperties()"
                    class="bg-white rounded-xl py-3 px-4 text-brand-black border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer">
                    <option value="">For Sale &amp; Rent</option>
                    @foreach(\App\Models\Property::STATUSES as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>

                {{-- Sort --}}
                <select
                    x-model="sortBy"
                    @change="filterProperties()"
                    class="bg-white rounded-xl py-3 px-4 text-brand-black border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                </select>
            </div>

            {{-- Results Counter --}}
            <div class="text-sm text-gray-600">
                Showing <strong x-text="filteredProperties.length"></strong> of <strong x-text="allProperties.length"></strong> loaded properties
            </div>
        </div>

        {{-- Results Section --}}
        <div x-show="filteredProperties.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="property in filteredProperties" :key="property.id">
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-shadow">
                    {{-- Image --}}
                    <div class="h-48 md:h-56 bg-gray-200 overflow-hidden">
                        <img loading="lazy" decoding="async" :src="property.featured_image_url" :alt="property.title" class="w-full h-full object-cover">
                    </div>

                    {{-- Content --}}
                    <div class="p-4 md:p-6">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-2" x-text="property.location"></p>
                        <h3 class="text-xl font-heading text-brand-black mb-2 line-clamp-2" x-text="property.title"></h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2" x-text="property.description || 'A beautiful property'"></p>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-primary" x-text="property.formatted_price"></span>
                            <span class="text-xs font-bold bg-primary/10 text-primary px-3 py-1 rounded-full" x-text="property.status"></span>
                        </div>

                        <a :href="`/properties/${property.slug}`" class="block w-full bg-brand-black text-white text-center rounded-full py-3 font-bold text-xs uppercase tracking-wider hover:bg-gray-800 transition">
                            VIEW DETAILS
                        </a>
                    </div>
                </div>
            </template>
        </div>

        {{-- Load More --}}
        <div x-show="hasMore && !searchQuery && !filterType && !filterStatus" class="text-center mt-10">
            <button
                @click="loadMore()"
                :disabled="loading"
                class="btn-primary px-12 py-4 text-sm tracking-[0.2em] font-bold disabled:opacity-50">
                <span x-text="loading ? 'LOADING...' : 'LOAD MORE PROPERTIES'"></span>
            </button>
        </div>
        <p x-show="hasMore && (searchQuery || filterType || filterStatus)" class="text-center text-xs text-gray-400 mt-6">
            Clear search/filters to load more properties from the server.
        </p>

        {{-- No Results --}}
        <div x-show="filteredProperties.length === 0" class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <p class="text-gray-600 mb-4">No properties found matching your search criteria.</p>
            <button @click="resetFilters()" class="bg-primary text-brand-black px-6 py-2 rounded-full font-bold text-sm uppercase hover:scale-105 transition-transform">
                Clear Filters
            </button>
        </div>
    </div>
</section>

<script>
function propertySearch(initialProperties, currentPage, lastPage) {
    return {
        // 2026-09-02 fix: previously received the raw Laravel paginator object
        // here (not a plain array) because the parent view passed $properties
        // directly instead of $properties->items() — spreading a non-iterable
        // object crashed silently and the grid never rendered a single
        // property. Now always a plain array from the start.
        allProperties: initialProperties,
        filteredProperties: initialProperties,
        currentPage: currentPage,
        lastPage: lastPage,
        loading: false,
        searchQuery: '',
        filterType: '',
        filterStatus: '',
        sortBy: 'newest',

        get hasMore() {
            return this.currentPage < this.lastPage;
        },

        filterProperties() {
            let results = [...this.allProperties];

            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                results = results.filter(p =>
                    (p.title && p.title.toLowerCase().includes(query)) ||
                    (p.location && p.location.toLowerCase().includes(query)) ||
                    (p.description && p.description.toLowerCase().includes(query))
                );
            }

            if (this.filterType) {
                results = results.filter(p => p.type === this.filterType);
            }

            if (this.filterStatus) {
                results = results.filter(p => p.status === this.filterStatus);
            }

            results.sort((a, b) => {
                switch (this.sortBy) {
                    case 'price-low':
                        return (parseFloat(a.price) || 0) - (parseFloat(b.price) || 0);
                    case 'price-high':
                        return (parseFloat(b.price) || 0) - (parseFloat(a.price) || 0);
                    case 'oldest':
                        return new Date(a.created_at) - new Date(b.created_at);
                    case 'newest':
                    default:
                        return new Date(b.created_at) - new Date(a.created_at);
                }
            });

            this.filteredProperties = results;
        },

        async loadMore() {
            if (this.loading || !this.hasMore) return;
            this.loading = true;

            try {
                const nextPage = this.currentPage + 1;
                const res = await fetch(`/api/properties?page=${nextPage}`, {
                    headers: { 'Accept': 'application/json' },
                });
                const json = await res.json();

                this.allProperties = this.allProperties.concat(json.data || []);
                this.currentPage = json.current_page || nextPage;
                this.lastPage = json.last_page || this.lastPage;
                this.filterProperties();
            } catch (e) {
                console.error('Error loading more properties:', e);
            } finally {
                this.loading = false;
            }
        },

        resetFilters() {
            this.searchQuery = '';
            this.filterType = '';
            this.filterStatus = '';
            this.sortBy = 'newest';
            this.filterProperties();
        },
    }
}
</script>
