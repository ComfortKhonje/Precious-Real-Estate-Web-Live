@extends('layouts.cms')

@section('title', 'Property Listings | PREC CMS')
@section('page_title', 'Property Listings')
@section('page_subtitle', 'Manage all listings shown on the website.')

@section('content')
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <div class="flex-1">
            <div class="relative">
                <input type="text" placeholder="Search by property name..."
                    class="w-full bg-white border border-gray-200 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                <i data-lucide="search" class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <select
                class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                <option>All Locations</option>
                <option>Lilongwe</option>
                <option>Blantyre</option>
                <option>Zomba</option>
                <option>Mzuzu</option>
            </select>
            <select
                class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                <option>All Types</option>
                <option>Residential</option>
                <option>Commercial</option>
            </select>
            <select
                class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                <option>All Status</option>
                <option>Available</option>
                <option>Sold</option>
                <option>Rented</option>
            </select>
            <a href="{{ route('cms.properties.create') }}" class="btn-primary">Add Property</a>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <p class="text-sm font-semibold text-brand-black/70">Listings</p>
            <p class="text-xs text-brand-black/50">{{ isset($properties) ? $properties->total() : 0 }} items</p>
        </div>

        @if (isset($properties) && $properties->count())
            <div class="p-6 space-y-4">
                @foreach ($properties as $prop)
                    <div class="flex items-center justify-between border border-gray-50 rounded-2xl p-4">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-14 bg-gray-100 rounded-md flex items-center justify-center text-sm">Img</div>
                            <div>
                                <div class="font-semibold">{{ $prop->title }}</div>
                                <div class="text-sm text-brand-black/60">{{ $prop->location }} — {{ $prop->type }} —
                                    {{ $prop->status }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('cms.properties.edit', $prop) }}" class="text-sm font-semibold">Edit</a>
                            <form id="delete-property-form-{{ $prop->id }}" method="POST" action="{{ route('cms.properties.destroy', $prop) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-sm text-red-600"
                                    @click="confirmFormId = 'delete-property-form-{{ $prop->id }}'; confirmMessage = 'Delete this property?'; confirmModalOpen = true">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-6">
                {{ $properties->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <h3 class="font-heading text-3xl leading-none mb-2">No properties yet</h3>
                <p class="text-brand-black/60 max-w-xl mx-auto">Add your first property listing. You can upload images, set
                    pricing, status, and mark featured properties.</p>
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('cms.properties.create') }}" class="btn-primary">Add Property</a>
                </div>
            </div>
        @endif
    </div>
@endsection
