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
                    <label class="text-sm font-semibold tracking-wider">Category</label>
                    <select name="category" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="">Select category</option>
                        @foreach(\App\Models\Property::CATEGORIES as $option)
                            <option value="{{ $option }}" {{ old('category') === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Type</label>
                    <select name="type" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="">Select type</option>
                        @foreach(\App\Models\Property::TYPES as $option)
                            <option value="{{ $option }}" {{ old('type') === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Listing Status</label>
                    <select name="status" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        @foreach(\App\Models\Property::STATUSES as $option)
                            <option value="{{ $option }}" {{ old('status') === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-brand-black/50">"For Rent" automatically shows "/ month" after the price on the site — don't type it into the price field.</p>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Price (Numerical)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="e.g., 120000000" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Currency</label>
                    <select name="currency" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        @foreach(\App\Models\Property::CURRENCIES as $option)
                            <option value="{{ $option }}" {{ old('currency', 'MWK') === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('currency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" required placeholder="e.g., Lilongwe, Area 10" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                    @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                <div class="space-y-2 md:col-span-2 lg:col-span-3">
                    <label class="text-sm font-semibold tracking-wider">Additional Features</label>
                    <input type="text" name="features" value="{{ old('features') }}" placeholder="e.g., Solar, Water tank, Electric fence (comma-separated)" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2 md:col-span-2 lg:col-span-3">
                    <label class="text-sm font-semibold tracking-wider">Nearby Amenities</label>
                    <input type="text" name="nearby_amenities" value="{{ old('nearby_amenities') }}" placeholder="e.g., St. Andrews School, Game Complex, Kamuzu Central Hospital (comma-separated)" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                    <p class="text-xs text-brand-black/50">Shown on the property page's "Location Details" section. Leave blank to hide that section entirely.</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Media Uploads</h3>
            <p class="text-sm text-brand-black/60 mb-6">Upload images for the property listing. Stored and optimized automatically (large/medium/thumbnail sizes generated on upload).</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <x-cms.image-upload name="featured_image" label="Select Featured Image" :required="true" />
                <x-cms.image-upload name="gallery[]" label="Upload Gallery Images" :multiple="true" />
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
                        <div class="text-sm text-brand-black/60">Listing is currently active and visible on the site.</div>
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
@endsection
