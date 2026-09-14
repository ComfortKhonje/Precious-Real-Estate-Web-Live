@extends('layouts.cms')

@section('title', 'Edit Property | PREC CMS')
@section('page_title', 'Edit Property')
@section('page_subtitle', 'Update details for ' . $property->title)

@section('content')
<form action="{{ route('cms.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white border border-gray-100 rounded-3xl p-6">
        <h3 class="font-heading text-3xl leading-none mb-1">Property Information</h3>
        <p class="text-sm text-brand-black/60 mb-6">Basic details shown on the property card and listing page.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Property Title</label>
                <input type="text" name="title" value="{{ old('title', $property->title) }}" required class="cms-input">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Category</label>
                <select name="category" class="cms-select">
                    <option value="">Select category</option>
                    @foreach(\App\Models\Property::CATEGORIES as $option)
                        <option value="{{ $option }}" {{ old('category', $property->category) === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Property Type</label>
                <select name="type" class="cms-select">
                    @foreach(\App\Models\Property::TYPES as $option)
                        <option value="{{ $option }}" {{ old('type', $property->type) === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Listing Status</label>
                <select name="status" class="cms-select">
                    @foreach(\App\Models\Property::STATUSES as $option)
                        <option value="{{ $option }}" {{ old('status', $property->status) === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-brand-black/50">"For Rent" automatically shows "/ month" after the price on the site — don't type it into the price field.</p>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Price (Numerical)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $property->price) }}" required class="cms-input">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Currency</label>
                <select name="currency" class="cms-select">
                    @foreach(\App\Models\Property::CURRENCIES as $option)
                        <option value="{{ $option }}" {{ old('currency', $property->currency) === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                @error('currency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2 md:col-span-2">
                <label class="text-sm font-semibold tracking-wider">Location</label>
                <input type="text" name="location" value="{{ old('location', $property->location) }}" required class="cms-input">
                @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2 md:col-span-2">
                <label class="text-sm font-semibold tracking-wider">Property Description</label>
                <textarea name="description" rows="5" required class="cms-input">{{ old('description', $property->description) }}</textarea>
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
                <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', $property->bedrooms) }}" class="cms-input">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Bathrooms</label>
                <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', $property->bathrooms) }}" class="cms-input">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Land Size</label>
                <input type="text" name="land_size" value="{{ old('land_size', $property->land_size) }}" class="cms-input">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Parking Spaces</label>
                <input type="number" name="parking_spaces" min="0" value="{{ old('parking_spaces', $property->parking_spaces) }}" class="cms-input">
            </div>
            <div class="space-y-2 lg:col-span-2">
                <label class="text-sm font-semibold tracking-wider">Additional Features</label>
                <x-cms.tag-input name="features" :value="old('features', is_array($property->features) ? implode(', ', $property->features) : $property->features)" placeholder="e.g., Solar, Water tank, Electric fence" />
            </div>
            <div class="space-y-2 lg:col-span-2">
                <label class="text-sm font-semibold tracking-wider">Nearby Amenities</label>
                <x-cms.tag-input name="nearby_amenities" :value="old('nearby_amenities', is_array($property->nearby_amenities) ? implode(', ', $property->nearby_amenities) : $property->nearby_amenities)" placeholder="e.g., St. Andrews School, Game Complex, Kamuzu Central Hospital" />
                <p class="text-xs text-brand-black/50">Shown on the property page's "Location Details" section. Leave blank to hide that section entirely.</p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl p-6">
        <h3 class="font-heading text-3xl leading-none mb-1">Media</h3>
        <p class="text-sm text-brand-black/60 mb-6">Replace the featured image, add more gallery images, or remove existing ones.</p>

        <div class="space-y-4 mb-6">
            @if($property->featured_image)
                <img loading="lazy" decoding="async" src="{{ $property->featuredImageUrl('thumbnail') }}" alt="Current featured image" class="w-32 h-20 object-cover rounded-xl border border-gray-100">
            @endif
            <x-cms.image-upload name="featured_image" label="Click to replace featured image" help="Leave empty to keep the current one" />
        </div>

        @php $galleryOnly = $property->images->where('is_featured', false); @endphp
        @if($galleryOnly->isNotEmpty())
            <div class="space-y-2 mb-6">
                <label class="text-sm font-semibold tracking-wider block">Existing Gallery Images</label>
                <p class="text-xs text-brand-black/50 mb-2">Check any you want removed when you save.</p>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                    @foreach($galleryOnly as $image)
                        <label class="relative block rounded-xl overflow-hidden border border-gray-100 cursor-pointer group">
                            <img loading="lazy" decoding="async" src="{{ $image->url('thumbnail') }}" alt="Gallery image" class="w-full h-20 object-cover">
                            <div class="absolute inset-0 bg-black/0 group-has-[:checked]:bg-red-600/60 transition flex items-center justify-center">
                                <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="w-5 h-5">
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <x-cms.image-upload name="gallery[]" label="Upload additional images" :multiple="true" />
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl p-6">
        <h3 class="font-heading text-3xl leading-none mb-1">Listing Settings</h3>
        <p class="text-sm text-brand-black/60 mb-6">Visibility and promotion settings.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-cms.toggle name="is_featured" :checked="old('is_featured', $property->is_featured)"
                label="Featured Listing" description="Show this listing in featured sections." />

            <x-cms.toggle name="is_available" :checked="old('is_available', $property->is_available)"
                label="Available" description="Listing is currently active and visible on the site." />
        </div>
    </div>

    <div class="flex flex-wrap gap-3 justify-end">
        <a href="{{ route('cms.properties.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Save Property</button>
    </div>
</form>
@endsection
