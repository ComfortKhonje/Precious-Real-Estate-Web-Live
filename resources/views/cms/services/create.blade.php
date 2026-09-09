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
                    class="cms-input @error('title') ring-2 ring-red-500 @enderror">
                @error('title')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Heading / Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline') }}"
                    placeholder="e.g., Accurate Valuations You Can Trust"
                    class="cms-input">
                <p class="text-xs text-brand-black/50 mt-1">Large headline on the services page. Falls back to the service title if left blank.</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Short Description</label>
                <textarea name="short_description" rows="3" placeholder="Brief summary of the service..."
                    class="cms-input">{{ old('short_description') }}</textarea>
                <p class="text-xs text-brand-black/50 mt-1">Max 500 characters</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Long Description (Services Page)</label>
                <textarea name="content" rows="7" placeholder="Longer, more detailed description shown on the services page..."
                    class="cms-input">{{ old('content') }}</textarea>
                <p class="text-xs text-brand-black/50 mt-1">Used on the services page instead of the short description above. Falls back to the short description if left blank. The home page always uses the short description.</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Highlights (Optional)</label>
                <input type="text" name="features" value="{{ old('features') }}"
                    placeholder="e.g., Registered valuers, Bank-accepted reports, Same-week turnaround"
                    class="cms-input">
                <p class="text-xs text-brand-black/50 mt-1">Comma-separated. Shown as a checklist on the services page — a short list (4 or fewer) stacks as one column, more become a two-column grid.</p>
            </div>

            <x-cms.image-upload name="banner_image" label="Banner Image" help="Upload a banner image for this service" />

            <div class="space-y-2" x-data="serviceIconPicker({{ Js::from($icons->map(fn ($i) => ['id' => $i->id, 'name' => $i->name, 'black_url' => $i->blackUrl(), 'yellow_url' => $i->yellowUrl()])) }}, {{ old('service_icon_id') ? (int) old('service_icon_id') : 'null' }})">
                <label class="text-sm font-semibold tracking-wider">Icon (Optional)</label>
                <p class="text-xs text-brand-black/50">Shown in the black-or-yellow color that keeps it readable on each card automatically — the toggle below is just a preview.</p>

                <input type="hidden" name="service_icon_id" :value="selectedId">

                <div class="flex items-center justify-end gap-1 bg-gray-100 rounded-full p-1 w-fit">
                    <button type="button" @click="previewColor = 'black'"
                        :class="previewColor === 'black' ? 'bg-brand-black text-white' : 'text-brand-black/60'"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider transition">Black</button>
                    <button type="button" @click="previewColor = 'yellow'"
                        :class="previewColor === 'yellow' ? 'bg-primary text-brand-black' : 'text-brand-black/60'"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider transition">Yellow</button>
                </div>

                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                    <template x-for="icon in icons" :key="icon.id">
                        <button type="button" @click="selectedId = (selectedId === icon.id ? null : icon.id)"
                            :class="selectedId === icon.id ? 'border-primary ring-2 ring-primary/30 bg-primary/10' : 'border-gray-200 hover:border-gray-300'"
                            class="flex flex-col items-center gap-2 p-3 rounded-2xl border-2 bg-white transition">
                            <img :src="previewColor === 'black' ? icon.black_url : icon.yellow_url" :alt="icon.name" class="w-8 h-8 object-contain">
                            <span class="text-[10px] font-semibold text-center leading-tight line-clamp-2" x-text="icon.name"></span>
                        </button>
                    </template>

                    <button type="button" @click="modalOpen = true"
                        class="flex flex-col items-center justify-center gap-2 p-3 rounded-2xl border-2 border-dashed border-gray-300 hover:border-primary hover:bg-primary/5 transition text-brand-black/50 hover:text-brand-black">
                        <i data-lucide="plus" class="w-6 h-6"></i>
                        <span class="text-[10px] font-semibold text-center leading-tight">Add New</span>
                    </button>
                </div>

                {{-- Add Icon Modal --}}
                <div x-show="modalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
                    <div class="relative bg-white rounded-3xl p-6 w-full max-w-md space-y-4" @click.stop>
                        <h4 class="font-heading text-2xl leading-none">Add New Icon</h4>
                        <p class="text-xs text-brand-black/50">Upload both the black and yellow SVG versions of the same icon.</p>

                        <div class="space-y-2">
                            <label class="text-xs font-semibold tracking-wider">Icon Name</label>
                            <input type="text" x-model="newName" placeholder="e.g., Land Surveying"
                                class="w-full bg-gray-100 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary focus:bg-white border border-transparent">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-semibold tracking-wider">Black Version (SVG)</label>
                            <input type="file" accept=".svg,image/svg+xml" @change="newBlack = $event.target.files[0]"
                                class="w-full bg-gray-100 rounded-xl py-2.5 px-4 text-sm border border-transparent">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-semibold tracking-wider">Yellow Version (SVG)</label>
                            <input type="file" accept=".svg,image/svg+xml" @change="newYellow = $event.target.files[0]"
                                class="w-full bg-gray-100 rounded-xl py-2.5 px-4 text-sm border border-transparent">
                        </div>

                        <p x-show="uploadError" x-text="uploadError" class="text-xs text-red-600"></p>

                        <div class="flex gap-2 pt-2">
                            <button type="button" @click="modalOpen = false"
                                class="flex-1 px-4 py-2.5 rounded-full border border-gray-200 font-semibold text-sm hover:bg-gray-50 transition">Cancel</button>
                            <button type="button" @click="uploadIcon()" :disabled="uploading"
                                class="flex-1 px-4 py-2.5 rounded-full bg-primary text-brand-black font-semibold text-sm hover:bg-primary/90 transition disabled:opacity-50">
                                <span x-text="uploading ? 'Uploading...' : 'Upload Icon'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <x-cms.toggle name="visible" :checked="old('visible', true)"
                    label="Visible" description="Shown on the public site." />
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
@include('cms.services._icon-picker-script')
@endsection