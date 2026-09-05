@extends('layouts.cms')

@section('title', 'Create Service | PREC CMS')
@section('page_title', 'Create Service')
@section('page_subtitle', 'Add a new service to your offerings.')

@section('content')
@if ($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 rounded-3xl p-6">
    <h3 class="font-semibold text-red-900 mb-3">Errors:</h3>
    <ul class="space-y-2 text-sm text-red-800">
        @foreach ($errors->all() as $error)
        <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('cms.services.store') }}" enctype="multipart/form-data"
    class="bg-white border border-gray-100 rounded-3xl p-6 space-y-6">
    @csrf

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="font-heading text-3xl leading-none">New Service</h3>
            <p class="text-sm text-brand-black/60 mt-1">Add a new service to your offerings.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('cms.services.index') }}"
                class="inline-flex items-center px-6 py-3 rounded-full border border-gray-200 font-semibold hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition">
                <i data-lucide="check" class="w-4 h-4 mr-2"></i> Create Service
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-5">
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Service Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    placeholder="e.g., Property Management"
                    class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 @error('title') ring-2 ring-red-500 @enderror">
                @error('title')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Short Description</label>
                <textarea name="short_description" rows="3" placeholder="Brief summary of the service..."
                    class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('short_description') }}</textarea>
                <p class="text-xs text-brand-black/50 mt-1">Max 500 characters</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Full Description</label>
                <textarea name="content" rows="7" placeholder="Detailed service description..."
                    class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('content') }}</textarea>
                <p class="text-xs text-brand-black/50 mt-1">You can use HTML formatting</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Banner Image</label>
                <input type="file" name="banner_image" accept="image/*"
                    class="w-full bg-gray-100 rounded-2xl py-3 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                <p class="text-xs text-brand-black/50 mt-1">Upload banner image for this service</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Icon (Optional)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" placeholder="e.g., lucide-home or icon-name"
                    class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                <p class="text-xs text-brand-black/50 mt-1">Emoji or icon reference</p>
            </div>

            <div class="space-y-3 pt-4 border-t border-gray-100">
                <label class="text-sm font-semibold tracking-wider">Visibility</label>
                <div class="space-y-2">
                    <label
                        class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 cursor-pointer transition">
                        <input type="radio" name="visible" value="1" checked
                            class="rounded border-gray-300 text-brand-black focus:ring-primary">
                        <span class="font-semibold">Visible</span>
                        <span class="text-xs text-brand-black/50 ml-auto">Shown on frontend</span>
                    </label>
                    <label
                        class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 cursor-pointer transition">
                        <input type="radio" name="visible" value="0"
                            class="rounded border-gray-300 text-brand-black focus:ring-primary">
                        <span class="font-semibold">Hidden</span>
                        <span class="text-xs text-brand-black/50 ml-auto">Not shown on frontend</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="space-y-5">
            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 sticky top-4">
                <h4 class="font-heading text-lg mb-3">Preview</h4>

                <div class="space-y-4">
                    <div class="border-b border-gray-200 pb-4">
                        <p class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Title</p>
                        <p class="font-heading text-xl text-brand-black" id="preview-title">
                            {{ old('title') ?: 'Service Title' }}
                        </p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <p class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Short Description</p>
                        <p class="text-sm text-brand-black/80" id="preview-short">
                            {{ old('short_description') ?: 'Your short description will appear here...' }}
                        </p>
                    </div>

                    <div
                        class="rounded-2xl bg-white border-2 border-dashed border-gray-200 p-6 text-center min-h-[200px] flex items-center justify-center">
                        @if (old('banner_image'))
                        <img loading="lazy" decoding="async" src="{{ old('banner_image') }}" alt="Banner preview"
                            class="max-h-[200px] object-cover rounded-xl" onerror="this.style.display='none'">
                        <div class="hidden" id="placeholder">
                            <p class="text-brand-black/60 text-sm">Banner image preview</p>
                        </div>
                        @else
                        <div id="placeholder">
                            <p class="text-brand-black/60">Add a banner image URL →</p>
                        </div>
                        @endif
                    </div>

                    <div class="bg-primary/20 border border-primary/30 rounded-2xl p-4 text-sm">
                        <p class="font-semibold text-brand-black mb-2 flex items-center gap-2"><i data-lucide="lightbulb" class="w-4 h-4"></i> Helpful Tips:</p>
                        <ul class="text-xs text-brand-black/70 space-y-1">
                            <li>• Service titles should be clear and descriptive</li>
                            <li>• Descriptions help customers understand your offerings</li>
                            <li>• Use high-quality banner images (recommended 1200x400px)</li>
                            <li>• Set visibility to show/hide from customers</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex gap-3 pt-6 border-t border-gray-100">
        <a href="{{ route('cms.services.index') }}"
            class="inline-flex items-center px-6 py-3 rounded-full border border-gray-200 font-semibold hover:bg-gray-50 transition">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex items-center px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition ml-auto">
            <i data-lucide="check" class="w-4 h-4 mr-2"></i> Create Service
        </button>
    </div>
</form>

<script>
    // Update preview as user types
    document.querySelectorAll('input[name="title"], textarea[name="short_description"], input[name="banner_image"]')
        .forEach(el => {
            el.addEventListener('input', function() {
                if (this.name === 'title') {
                    document.getElementById('preview-title').textContent = this.value || 'Service Title';
                } else if (this.name === 'short_description') {
                    document.getElementById('preview-short').textContent = this.value ||
                        'Your short description will appear here...';
                }
            });
        });
</script>
@endsection