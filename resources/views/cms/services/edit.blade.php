@extends('layouts.cms')

@section('title', 'Edit Service | PREC CMS')
@section('page_title', 'Edit Service')
@section('page_subtitle', 'Update content with simple formatting.')

@section('content')
<form method="POST" action="{{ route('cms.services.update', ['slug' => str($service->title)->slug()]) }}" enctype="multipart/form-data"
    class="bg-white border border-gray-100 rounded-3xl p-6 space-y-6">
    @csrf
    @method('PUT')

    <div class="mb-6">
        <h3 class="font-heading text-3xl leading-none">{{ $service->title }}</h3>
        <p class="text-sm text-brand-black/60 mt-1">Update service content and visibility for the public site.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-5">
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Service Title</label>
                <input type="text" name="title" value="{{ old('title', $service->title) }}"
                    class="cms-input">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Heading / Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $service->tagline) }}"
                    placeholder="e.g., Accurate Valuations You Can Trust"
                    class="cms-input">
                <p class="text-xs text-brand-black/50 mt-1">Large headline on the services page. Falls back to the service title if left blank.</p>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Short Description</label>
                <textarea name="short_description" rows="3" placeholder="Short summary..."
                    class="cms-input">{{ old('short_description', $service->short_description) }}</textarea>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Long Description (Services Page)</label>
                <textarea name="content" rows="7" placeholder="Longer, more detailed description shown on the services page..."
                    class="cms-input">{{ old('content', $service->content) }}</textarea>
                <p class="text-xs text-brand-black/50 mt-1">Used on the services page instead of the short description above. Falls back to the short description if left blank. The home page always uses the short description.</p>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold tracking-wider">Highlights (Optional)</label>
                <x-cms.tag-input name="features" :value="old('features', is_array($service->features) ? implode(', ', $service->features) : '')"
                    placeholder="e.g., Registered valuers, Bank-accepted reports..."
                    help="Shown as a checklist on the services page — a short list (4 or fewer) stacks as one column, more become a two-column grid." />
            </div>
            <x-cms.image-upload name="banner_image" label="Click to replace banner image" help="Leave empty to keep the current one" />

            <div class="space-y-2" x-data="serviceIconPicker({{ Js::from($icons->map(fn ($i) => ['id' => $i->id, 'name' => $i->name, 'black_url' => $i->blackUrl(), 'yellow_url' => $i->yellowUrl()])) }}, {{ old('service_icon_id') ? (int) old('service_icon_id') : ($service->service_icon_id ?? 'null') }})">
                <label class="text-sm font-semibold tracking-wider">Icon</label>
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

            <x-cms.toggle name="visible" :checked="old('visible', $service->visible)"
                label="Visible" description="Shown on the public site." />
        </div>

        <div class="space-y-5">
            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                <h4 class="font-heading text-3xl leading-none mb-2">Banner Preview</h4>
                <p class="text-sm text-brand-black/60 mb-5">Current banner image used on the public service page.
                </p>
                <div class="border-2 border-dashed border-gray-200 rounded-3xl p-10 text-center bg-white">
                    @if ($service->banner_image)
                    <img loading="lazy" decoding="async" src="{{ $service->bannerImageUrl('medium') }}" alt="{{ $service->title }} banner"
                        class="mx-auto h-40 object-cover rounded-3xl">
                    @else
                    <p class="font-semibold">No banner image configured yet</p>
                    <p class="text-sm text-brand-black/60 mt-1">Upload a banner image to display one.</p>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                <h4 class="font-heading text-3xl leading-none mb-2">Saved Content</h4>
                <p class="text-sm text-brand-black/60 mb-5">Last updated {{ $service->updated_at->diffForHumans() }}.</p>
                <div class="rounded-3xl border border-dashed border-gray-200 p-6 bg-white text-sm text-brand-black/70">
                    {!! nl2br(e($service->short_description ?: 'No short description yet.')) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex gap-3 pt-6 border-t border-gray-100">
        <a href="{{ route('cms.services.index') }}"
            class="inline-flex items-center px-6 py-3 rounded-full border border-gray-200 font-semibold hover:bg-gray-50 transition">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back
        </a>
        <button type="submit"
            class="inline-flex items-center px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition ml-auto">
            <i data-lucide="check" class="w-4 h-4 mr-2"></i> Save Changes
        </button>
        <button type="button"
            @click="confirmFormId = 'delete-service-form'; confirmMessage = 'Delete this service? This cannot be undone.'; confirmModalOpen = true"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-red-100 text-red-700 font-semibold hover:bg-red-200 transition">
            <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
        </button>
    </div>
</form>

<form id="delete-service-form" method="POST" action="{{ route('cms.services.destroy', $service) }}" class="hidden">
    @csrf
    @method('DELETE')
</form>
@include('cms.services._icon-picker-script')
@endsection