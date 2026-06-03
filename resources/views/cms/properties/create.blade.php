@extends('layouts.cms')

@section('title', 'Add Property | PREC CMS')
@section('page_title', 'Add Property')
@section('page_subtitle', 'Create a new listing for the website.')

@section('content')
    <form action="{{ route('cms.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Property Information</h3>
            <p class="text-sm text-brand-black/60 mb-6">Basic details shown on the property card and listing page.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., 3 Bedroom House in Area 10" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Type</label>
                    <input type="text" name="type" value="{{ old('type') }}" required placeholder="e.g., House, Apartment, Plot" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Price (Numerical)</label>
                    <input type="number" name="price" value="{{ old('price') }}" required placeholder="e.g., 120000000" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Currency</label>
                    <select name="currency" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="MWK" {{ old('currency') == 'MWK' ? 'selected' : '' }}>MWK</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                    @error('currency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" required placeholder="e.g., Lilongwe, Area 10" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                    @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Listing Status</label>
                    <select name="status" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="For Sale" {{ old('status') == 'For Sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="For Rent" {{ old('status') == 'For Rent' ? 'selected' : '' }}>For Rent</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Property Description</label>
                    <textarea name="description" rows="5" required placeholder="Write a clear description of the property..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Property Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Extra details that help buyers and renters decide faster.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Bedrooms</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" min="0" placeholder="0" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Bathrooms</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" min="0" placeholder="0" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Land Size</label>
                    <input type="text" name="land_size" value="{{ old('land_size') }}" placeholder="e.g., 500 sqm, 0.25 acre" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Parking Spaces</label>
                    <input type="number" name="parking_spaces" value="{{ old('parking_spaces') }}" min="0" placeholder="0" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Media Uploads</h3>
            <p class="text-sm text-brand-black/60 mb-6">Upload images for the property listing.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <label class="text-sm font-semibold tracking-wider block">Featured Image (Required)</label>
                    <div class="relative group">
                        <input type="file" name="featured_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-gray-200 rounded-3xl p-8 text-center bg-gray-50 group-hover:bg-gray-100 transition">
                            <div class="w-12 h-12 mx-auto rounded-2xl bg-primary/20 flex items-center justify-center mb-2">
                                <svg class="w-6 h-6 text-brand-black/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <p class="text-sm font-semibold">Select Featured Image</p>
                        </div>
                    </div>
                    @error('featured_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4">
                    <label class="text-sm font-semibold tracking-wider block">Gallery Images (Optional)</label>
                    <div class="relative group">
                        <input type="file" name="gallery[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-gray-200 rounded-3xl p-8 text-center bg-gray-50 group-hover:bg-gray-100 transition">
                            <div class="w-12 h-12 mx-auto rounded-2xl bg-primary/20 flex items-center justify-center mb-2">
                                <svg class="w-6 h-6 text-brand-black/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-sm font-semibold">Upload Gallery Images</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Listing Settings</h3>
            <p class="text-sm text-brand-black/60 mb-6">Visibility and promotion settings.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <label class="flex items-center justify-between gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer hover:bg-gray-100 transition">
                    <div>
                        <div class="font-semibold">Featured Listing</div>
                        <div class="text-sm text-brand-black/60">Show this property in featured sections.</div>
                    </div>
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                </label>
                <label class="flex items-center justify-between gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer hover:bg-gray-100 transition">
                    <div>
                        <div class="font-semibold">Available</div>
                        <div class="text-sm text-brand-black/60">Listing is currently active and visible.</div>
                    </div>
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                </label>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <a href="{{ route('cms.properties.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Save Property</button>
        </div>
    </form>

    @push('scripts')
        @vite('resources/js/cms-media.js')
    @endpush
@endsection
