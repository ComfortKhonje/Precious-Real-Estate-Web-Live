@extends('layouts.cms')

@section('title', 'Edit Property | PREC CMS')
@section('page_title', 'Edit Property')
@section('page_subtitle', 'Update listing details.')

@section('content')
    <form method="POST" action="{{ route('cms.properties.update', $property) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Property Information</h3>
            <p class="text-sm text-brand-black/60 mb-6">Basic details shown on the property card and listing page.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Title</label>
                    <input type="text" name="title" value="{{ old('title', $property->title) }}" required
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Category</label>
                    <select name="category" class="w-full bg-gray-100 rounded-2xl py-4 px-5 cursor-pointer">
                        <option value="">Select category</option>
                        <option {{ old('category', $property->category) === 'Residential' ? 'selected' : '' }}>Residential
                        </option>
                        <option {{ old('category', $property->category) === 'Commercial' ? 'selected' : '' }}>Commercial
                        </option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Type</label>
                    <input type="text" name="type" value="{{ old('type', $property->type) }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Price</label>
                    <input type="text" name="price" value="{{ old('price', $property->price) }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Location</label>
                    <input type="text" name="location" value="{{ old('location', $property->location) }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Status</label>
                    <select name="status" class="w-full bg-gray-100 rounded-2xl py-4 px-5 cursor-pointer">
                        <option {{ old('status', $property->status) === 'available' ? 'selected' : '' }}>Available</option>
                        <option {{ old('status', $property->status) === 'sold' ? 'selected' : '' }}>Sold</option>
                        <option {{ old('status', $property->status) === 'rented' ? 'selected' : '' }}>Rented</option>
                    </select>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Property Description</label>
                    <textarea name="description" rows="5" class="w-full bg-gray-100 rounded-2xl py-4 px-5">{{ old('description', $property->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Media Uploads</h3>
            <p class="text-sm text-brand-black/60 mb-6">Drag and drop images. Uploads are stored in the public storage.</p>

            <div id="media-dropzone"
                class="border-2 border-dashed border-gray-200 rounded-3xl p-6 text-center bg-gray-50 cursor-pointer">
                <input type="file" accept="image/*" class="hidden" multiple />
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <p class="font-semibold">Drop images here</p>
                <p class="text-sm text-brand-black/60 mt-1">or click to browse</p>
                <div class="mt-4 media-preview text-left"></div>
            </div>
            <input type="hidden" name="media" value="{{ old('media', json_encode($property->images->pluck('image_path')->toArray() ?? [])) }}">
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
