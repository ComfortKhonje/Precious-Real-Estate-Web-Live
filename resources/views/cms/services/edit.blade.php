@extends('layouts.cms')

@section('title', 'Edit Service | PREC CMS')
@section('page_title', 'Edit Service')
@section('page_subtitle', 'Update content with simple formatting.')

@section('content')
    <form method="POST" action="{{ route('cms.services.update', ['slug' => str($service->title)->slug()]) }}"
        class="bg-white border border-gray-100 rounded-3xl p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-heading text-3xl leading-none">{{ $service->title }}</h3>
                <p class="text-sm text-brand-black/60 mt-1">Update service content and visibility for the public site.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="submit" class="btn-primary">Save Service</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Service Title</label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Short Description</label>
                    <textarea name="short_description" rows="3" placeholder="Short summary..."
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('short_description', $service->short_description) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Full Description</label>
                    <textarea name="content" rows="7" placeholder="Full service description..."
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('content', $service->content) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Banner Image URL</label>
                    <input type="text" name="banner_image" value="{{ old('banner_image', $service->banner_image) }}"
                        placeholder="https://example.com/banner.jpg"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Visibility</label>
                    <div class="flex items-center gap-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="visible" value="1"
                                {{ old('visible', $service->visible) == 1 ? 'checked' : '' }}
                                class="rounded border-gray-300 text-brand-black focus:ring-primary">
                            <span>Visible</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="visible" value="0"
                                {{ old('visible', $service->visible) == 0 ? 'checked' : '' }}
                                class="rounded border-gray-300 text-brand-black focus:ring-primary">
                            <span>Hidden</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                    <h4 class="font-heading text-3xl leading-none mb-2">Banner Preview</h4>
                    <p class="text-sm text-brand-black/60 mb-5">Banner image URL will be used on the public service page.
                    </p>
                    <div class="border-2 border-dashed border-gray-200 rounded-3xl p-10 text-center bg-white">
                        @if ($service->banner_image)
                            <img src="{{ $service->banner_image }}" alt="{{ $service->title }} banner"
                                class="mx-auto h-40 object-cover rounded-3xl">
                        @else
                            <p class="font-semibold">No banner image configured yet</p>
                            <p class="text-sm text-brand-black/60 mt-1">Add a banner image URL above.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                    <h4 class="font-heading text-3xl leading-none mb-2">Saved Content</h4>
                    <p class="text-sm text-brand-black/60 mb-5">Last updated {{ $service->updated_at->diffForHumans() }}.
                    </p>
                    <div class="rounded-3xl border border-dashed border-gray-200 p-6 bg-white text-sm text-brand-black/70">
                        {!! nl2br(e($service->short_description ?: 'No short description yet.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
