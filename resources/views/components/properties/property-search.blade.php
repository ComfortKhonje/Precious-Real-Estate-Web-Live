@props(['initialProperties' => []])

<section id="properties-search" class="py-8 px-4 md:px-6 bg-gray-50">
    <div class="max-w-7xl mx-auto" x-data="propertySearch({{ json_encode($initialProperties) }})">
        {{-- Search & Filter Bar --}}
        <div class="space-y-4 mb-8">
            {{-- Search Input --}}
            <div class="flex flex-col md:flex-row gap-4">
                <input 
                    type="text" 
                    x-model="searchQuery"
                    @input="filterProperties()"
                    placeholder="Search by location or property type..."
                    class="flex-1 bg-white rounded-xl py-3 px-4 text-brand-black border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">
                
                {{-- Filter Options --}}
                <select 
                    x-model="filterType"
                    @change="filterProperties()"
                    class="bg-white rounded-xl py-3 px-4 text-brand-black border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer">
                    <option value="">All Types</option>
                    <option value="Residential">Residential</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Industrial">Industrial</option>
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
                Showing <strong x-text="filteredProperties.length"></strong> of <strong x-text="allProperties.length"></strong> properties
            </div>
        </div>

        {{-- Results Section --}}
        <div x-show="filteredProperties.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="property in filteredProperties" :key="property.id">
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-shadow">
                    {{-- Image --}}
                    <div class="h-48 md:h-56 bg-gray-200 overflow-hidden">
                        <img :src="getPropertyImage(property)" :alt="property.title" class="w-full h-full object-cover">
                    </div>
                    
                    {{-- Content --}}
                    <div class="p-4 md:p-6">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-2" x-text="property.location"></p>
                        <h3 class="text-xl font-heading text-brand-black mb-2 line-clamp-2" x-text="property.title"></h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2" x-text="property.description || 'A beautiful property'"></p>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-primary" x-text="formatPrice(property.price)"></span>
                            <span class="text-xs font-bold bg-primary/10 text-primary px-3 py-1 rounded-full" x-text="property.status || 'For Rent'"></span>
                        </div>

                        <a :href="`/properties/${property.id}`" class="block w-full bg-brand-black text-white text-center rounded-full py-3 font-bold text-xs uppercase tracking-wider hover:bg-gray-800 transition">
                            VIEW DETAILS
                        </a>
                    </div>
                </div>
            </template>
        </div>

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
function propertySearch(initialProperties) {
    return {
        allProperties: initialProperties,
        filteredProperties: initialProperties,
        searchQuery: '',
        filterType: '',
        sortBy: 'newest',

        filterProperties() {
            let results = [...this.allProperties];

            // Search filter
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                results = results.filter(p => 
                    (p.title && p.title.toLowerCase().includes(query)) ||
                    (p.location && p.location.toLowerCase().includes(query)) ||
                    (p.description && p.description.toLowerCase().includes(query))
                );
            }

            // Type filter
            if (this.filterType) {
                results = results.filter(p => p.type === this.filterType);
            }

            // Sort
            results.sort((a, b) => {
                switch(this.sortBy) {
                    case 'price-low':
                        return (a.price || 0) - (b.price || 0);
                    case 'price-high':
                        return (b.price || 0) - (a.price || 0);
                    case 'oldest':
                        return new Date(a.created_at) - new Date(b.created_at);
                    case 'newest':
                    default:
                        return new Date(b.created_at) - new Date(a.created_at);
                }
            });

            this.filteredProperties = results;
        },

        resetFilters() {
            this.searchQuery = '';
            this.filterType = '';
            this.sortBy = 'newest';
            this.filterProperties();
        },

        getPropertyImage(property) {
            if (property.media && Array.isArray(property.media) && property.media[0]) {
                return `/storage/${property.media[0]}`;
            }
            return '/brand-assets/4 Properties Page/Property image 1.png';
        },

        formatPrice(price) {
            if (!price) return 'Price on Request';
            return 'MWK ' + parseInt(price).toLocaleString();
        }
    }
}
</script>
