@extends('layouts.cms')

@section('title', 'Add Service | PREC CMS')
@section('page_title', 'Add Service')
@section('page_subtitle', 'Create a new service entry with title, description and banner image.')

@section('content')
    <form method="POST" action="{{ route('cms.services.store') }}" enctype="multipart/form-data"
        class="bg-white border border-gray-100 rounded-3xl p-6 space-y-6">
        @csrf

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-heading text-3xl leading-none">Add New Service</h3>
                <p class="text-sm text-brand-black/60 mt-1">Create a new service entry for the public site.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="submit" class="btn-primary">Save Service</button>
                <a href="{{ route('cms.services.index') }}" class="btn-secondary">Back to list</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Service Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Short Description</label>
                    <textarea name="short_description" rows="3" placeholder="Short summary..."
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('short_description') }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Full Description</label>
                    <textarea name="content" rows="7" placeholder="Full service description..."
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('content') }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Banner Image URL</label>
                    <input type="text" name="banner_image" value="{{ old('banner_image') }}"
                        placeholder="https://example.com/banner.jpg"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Upload Banner Image</label>
                    <input type="file" name="banner_image_file" accept="image/*"
                        class="w-full text-sm text-brand-black rounded-2xl file:border-0 file:bg-primary/10 file:px-4 file:py-3 file:rounded-full file:text-sm file:font-semibold file:text-brand-black">
                    <p class="text-xs text-brand-black/50">Optional: upload an image file instead of using an external URL.</p>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Visibility</label>
                    <div class="flex items-center gap-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="visible" value="1"
                                {{ old('visible', true) == 1 ? 'checked' : '' }}
                                class="rounded border-gray-300 text-brand-black focus:ring-primary">
                            <span>Visible</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="visible" value="0"
                                {{ old('visible', true) == 0 ? 'checked' : '' }}
                                class="rounded border-gray-300 text-brand-black focus:ring-primary">
                            <span>Hidden</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                    <h4 class="font-heading text-3xl leading-none mb-2">Banner Preview</h4>
                    <p class="text-sm text-brand-black/60 mb-5">Upload a file or provide a URL. The selected image will show on the public service page.</p>
                    <div class="border-2 border-dashed border-gray-200 rounded-3xl p-10 text-center bg-white">
                        <p class="font-semibold">No banner image yet</p>
                        <p class="text-sm text-brand-black/60 mt-1">A preview will display after saving this service.</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                    <h4 class="font-heading text-3xl leading-none mb-2">Draft Notes</h4>
                    <p class="text-sm text-brand-black/60">Add a new service entry for the public site. You can update the image later if needed.</p>
                </div>
            </div>
        </div>
    </form>
@endsection
