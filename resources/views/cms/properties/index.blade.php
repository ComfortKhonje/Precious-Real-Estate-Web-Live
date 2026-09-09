@extends('layouts.cms')

@section('title', 'Property Listings | PREC CMS')
@section('page_title', 'Property Listings')
@section('page_subtitle', 'Manage all listings shown on the website.')

@section('content')
<x-cms.list-toolbar
    :search-route="route('cms.properties.index')"
    :search-value="request('search')"
    search-placeholder="Search by property name..."
    :clear-route="request()->anyFilled(['search', 'location', 'type', 'status']) ? route('cms.properties.index') : null"
    :create-route="route('cms.properties.create')"
    create-label="Add Property">
    <x-slot:filters>
        <select name="location" onchange="this.form.submit()" class="cms-select bg-white border-gray-200 py-3 px-4 text-sm">
            <option value="">All Locations</option>
            @foreach($locations as $location)
            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
            @endforeach
        </select>
        <select name="type" onchange="this.form.submit()" class="cms-select bg-white border-gray-200 py-3 px-4 text-sm">
            <option value="">All Types</option>
            @foreach($types as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()" class="cms-select bg-white border-gray-200 py-3 px-4 text-sm">
            <option value="">All Status</option>
            <option value="For Sale" {{ request('status') == 'For Sale' ? 'selected' : '' }}>For Sale</option>
            <option value="For Rent" {{ request('status') == 'For Rent' ? 'selected' : '' }}>For Rent</option>
        </select>
    </x-slot:filters>
</x-cms.list-toolbar>

@if ($properties->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($properties as $prop)
            <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition">
                <x-cms.media-thumb :src="$prop->featuredImageUrl('medium')" :alt="$prop->title" icon="home">
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm {{ $prop->status === 'For Sale' ? 'bg-brand-black text-white' : 'bg-primary text-brand-black' }}">
                            {{ $prop->status }}
                        </span>
                        @if($prop->is_featured)
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm bg-white/90 text-brand-black flex items-center gap-1">
                                <i data-lucide="star" class="w-3 h-3"></i> Featured
                            </span>
                        @endif
                    </div>
                    <x-cms.card-hover-actions
                        :edit-route="route('cms.properties.edit', $prop)"
                        delete-form-id="delete-property-form-{{ $prop->id }}"
                        delete-message="Delete this property?" />
                </x-cms.media-thumb>

                <form id="delete-property-form-{{ $prop->id }}" method="POST" action="{{ route('cms.properties.destroy', $prop) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="p-4">
                    <h3 class="font-heading text-lg font-semibold text-brand-black truncate">{{ $prop->title }}</h3>
                    <p class="text-sm text-yellow-600 font-semibold mt-1 truncate">{{ $prop->location }} &middot; {{ $prop->type }}</p>

                    <div class="flex items-center gap-4 mt-2 text-xs text-brand-black/50">
                        @if($prop->bedrooms)
                            <span class="flex items-center gap-1"><i data-lucide="bed" class="w-3.5 h-3.5"></i> {{ $prop->bedrooms }}</span>
                        @endif
                        @if($prop->bathrooms)
                            <span class="flex items-center gap-1"><i data-lucide="bath" class="w-3.5 h-3.5"></i> {{ $prop->bathrooms }}</span>
                        @endif
                    </div>

                    <p class="font-heading font-bold text-xl text-brand-black mt-2">{{ $prop->formatted_price }}</p>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                        <x-cms.status-pill
                            :active="$prop->is_available"
                            active-label="Available"
                            inactive-label="Unavailable"
                            active-icon="check-circle"
                            inactive-icon="x-circle" />
                    </div>

                    <a href="{{ route('cms.properties.edit', $prop) }}"
                        class="mt-3 block w-full text-center px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold transition flex items-center justify-center gap-1">
                        Edit Property <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if($properties->hasPages())
        <div class="mt-8">
            {{ $properties->links() }}
        </div>
    @endif
@elseif(request()->anyFilled(['search', 'location', 'type', 'status']))
    <x-cms.empty-state
        icon="search-x"
        title="No matching properties"
        description="Try a different search term or clear the filters above."
        :action-route="route('cms.properties.index')"
        action-label="Clear Filters"
        action-icon="x" />
@else
    <x-cms.empty-state
        icon="home"
        title="No properties yet"
        description="Add your first property listing. You can upload images, set pricing, status, and mark featured properties."
        :action-route="route('cms.properties.create')"
        action-label="Add Property" />
@endif
@endsection
