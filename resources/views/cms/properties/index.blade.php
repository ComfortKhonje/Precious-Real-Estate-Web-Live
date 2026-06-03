@extends('layouts.cms')

@section('title', 'Property Listings | PREC CMS')
@section('page_title', 'Property Listings')
@section('page_subtitle', 'Manage all listings shown on the website.')

@section('content')
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <form action="{{ route('cms.properties.index') }}" method="GET" class="flex-1 flex flex-col lg:flex-row gap-4">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by property name..." class="w-full bg-white border border-gray-200 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                <svg class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"/>
                </svg>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-ui.select name="location" onchange="this.form.submit()" class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select name="type" onchange="this.form.submit()" class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select name="status" onchange="this.form.submit()" class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                    <option value="">All Status</option>
                    <option value="For Sale" {{ request('status') == 'For Sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="For Rent" {{ request('status') == 'For Rent' ? 'selected' : '' }}>For Rent</option>
                </x-ui.select>
                @if(request()->anyFilled(['search', 'location', 'type', 'status']))
                    <a href="{{ route('cms.properties.index') }}" class="p-3 rounded-2xl bg-gray-100 text-brand-black/60 hover:bg-gray-200 transition" title="Clear Filters">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>
        </form>
        <a href="{{ route('cms.properties.create') }}" class="btn-primary">Add Property</a>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <p class="text-sm font-semibold text-brand-black/70">Listings</p>
            <p class="text-xs text-brand-black/50">{{ $properties->total() }} items</p>
        </div>

        @if($properties->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-xs uppercase tracking-widest text-brand-black/50 font-bold">
                            <th class="px-6 py-4">Property</th>
                            <th class="px-6 py-4">Location</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Availability</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($properties as $property)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                            <img src="{{ asset($property->featured_image) }}" alt="" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-semibold text-brand-black">{{ $property->title }}</div>
                                            <div class="text-xs text-brand-black/50">{{ $property->type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-brand-black/70">{{ $property->location }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-brand-black">{{ $property->formatted_price }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full {{ $property->status === 'For Sale' ? 'bg-brand-black text-white' : 'bg-primary/40 text-brand-black' }}">
                                        {{ $property->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 text-xs {{ $property->is_available ? 'text-green-600' : 'text-red-600' }}">
                                        <span class="w-2 h-2 rounded-full {{ $property->is_available ? 'bg-green-600' : 'bg-red-600' }}"></span>
                                        {{ $property->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('cms.properties.edit', $property) }}" class="p-2 rounded-xl bg-gray-100 text-brand-black/60 hover:bg-primary/20 hover:text-brand-black transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15.232 5.232 3.536 3.536m-2.036-5.036a2.5 2.5 0 1 1 3.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('cms.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl bg-gray-100 text-red-400 hover:bg-red-50 hover:text-red-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($properties->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $properties->links() }}
                </div>
            @endif
        @else
            <div class="p-8 text-center">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <h3 class="font-heading text-3xl leading-none mb-2">No properties yet</h3>
                <p class="text-brand-black/60 max-w-xl mx-auto">Add your first property listing. You can upload images, set pricing, status, and mark featured properties.</p>
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('cms.properties.create') }}" class="btn-primary">Add Property</a>
                </div>
            </div>
        @endif
    </div>
@endsection
