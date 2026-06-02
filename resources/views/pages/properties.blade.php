@extends('layouts.app')
@section('title', 'Properties - Precious Real Estate')
@section('content')
    <x-properties.page-hero />

    <section class="bg-white py-24 md:py-32 relative overflow-hidden">
        {{-- Background Grid --}}
        <img src="{{ asset('brand-assets/website-pages/grid-background.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-10 pointer-events-none">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Section Header --}}
            <div class="mb-16 md:mb-20">
                <div class="badge-yellow mb-4">Latest Listings</div>
                <h2 class="text-4xl md:text-6xl font-heading text-brand-black uppercase tracking-tight">Available <br><span class="text-gray-400">Properties</span></h2>
            </div>

            {{-- Properties Grid --}}
            <div id="property-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                @include('components.properties.property-grid-items', ['properties' => $properties])
            </div>

            {{-- Load More --}}
            @if($properties->hasMorePages())
                <div class="mt-20 flex justify-center">
                    <button id="load-more" data-next-page="{{ $properties->currentPage() + 1 }}" class="btn-primary px-12 py-5 text-sm tracking-[0.2em] font-bold shadow-xl hover:scale-105 active:scale-95 transition-all duration-300">
                        LOAD MORE PROPERTIES
                    </button>
                </div>
            @endif
        </div>
    </section>

    <x-shared.cta-get-started />
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more');
        const grid = document.getElementById('property-grid');

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const nextPage = this.getAttribute('data-next-page');
                const url = new URL(window.location.href);
                url.searchParams.set('page', nextPage);

                this.innerText = 'LOADING...';
                this.disabled = true;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (html.trim() === '') {
                        loadMoreBtn.parentElement.remove();
                        return;
                    }

                    grid.insertAdjacentHTML('beforeend', html);

                    const newPage = parseInt(nextPage) + 1;
                    this.setAttribute('data-next-page', newPage);
                    this.innerText = 'LOAD MORE PROPERTIES';
                    this.disabled = false;

                    // Check if there are no more pages (this is a simple check, ideally the server would tell us)
                    // If the server returns empty or less than 6 items, we might want to hide the button
                })
                .catch(error => {
                    console.error('Error loading properties:', error);
                    this.innerText = 'LOAD MORE PROPERTIES';
                    this.disabled = false;
                });
            });
        }
    });
</script>
@endpush
