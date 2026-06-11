@extends('layouts.app')
@section('title', 'Properties - Precious Real Estate')
@section('content')
<x-properties.page-hero />
<x-properties.property-search :initialProperties="$properties" />
<x-home.cta badge="Get Started" title="Need Professional Property Assistance?"
    description="Our team is ready to support you with trusted real estate solutions." />
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