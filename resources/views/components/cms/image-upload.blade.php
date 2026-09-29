@props([
    'name',
    'label',
    'multiple' => false,
    'accept' => 'image/*',
    'required' => false,
    'help' => null,
    'maxSizeMb' => 5,
    // Single mode: URL of the image already saved, shown as "Current" with
    // a Replace action. Required is then satisfied without a new pick.
    'current' => null,
    // Multiple mode: images already saved, as [['id' => 1, 'url' => '...'], ...].
    // Each gets a Remove/Undo toggle; marked ones post as `removeName`.
    'existing' => [],
    'removeName' => 'remove_images[]',
])

{{--
    Shared CMS image field (properties, announcements, services, team).

    2026-09-29 rebuild. The picked files now live in Alpine state (`files`)
    and are copied into the real, named <input type="file"> on every change.
    The previous version merged the input's own FileList with the files that
    had just been picked into that same input, so the first pick in a
    gallery attached every image twice and the gallery was saved doubled.
    Previews also came back from FileReader out of order, so "remove" on a
    tile could drop a different file than the one shown. Object URLs are
    created synchronously, in pick order, so a tile always matches its file.

    `required` is checked here on submit rather than with the HTML attribute:
    the named input is hidden, and a hidden required field blocks the form
    with no visible message.

    Max size (default 5MB) is enforced at pick time and matches every
    controller's own `max:5120` rule, so the server is never sent a file it
    will reject (see the PostTooLargeException handler in bootstrap/app.php).
--}}
@php
    $inputId = 'upload-'.\Illuminate\Support\Str::random(8);
    $errorKey = rtrim($name, '[]');
@endphp

<div class="space-y-3"
    x-data="{
        multiple: {{ $multiple ? 'true' : 'false' }},
        required: {{ $required ? 'true' : 'false' }},
        maxBytes: {{ (int) ($maxSizeMb * 1024 * 1024) }},
        maxMb: {{ (int) $maxSizeMb }},
        current: @js($current),
        existing: @js(collect($existing)->map(fn ($image) => ['id' => $image['id'], 'url' => $image['url'], 'removed' => false])->values()),
        files: [],
        sizeError: null,
        requiredError: false,
        dragging: false,

        init() {
            const form = this.$el.closest('form');
            if (!form) return;
            form.addEventListener('submit', (event) => {
                if (this.required && !this.current && this.files.length === 0) {
                    event.preventDefault();
                    this.requiredError = true;
                    this.$el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        },
        addFiles(fileList) {
            this.sizeError = null;
            this.requiredError = false;
            const incoming = Array.from(fileList || []).filter((f) => f.type.startsWith('image/'));
            const oversized = incoming.filter((f) => f.size > this.maxBytes);
            const accepted = incoming.filter((f) => f.size <= this.maxBytes);

            if (oversized.length) {
                const names = oversized.map((f) => f.name).join(', ');
                this.sizeError = oversized.length === 1
                    ? `“${names}” is over the ${this.maxMb}MB limit and wasn’t added.`
                    : `${oversized.length} files are over the ${this.maxMb}MB limit and weren’t added: ${names}.`;
            }
            if (!accepted.length) return;

            const picked = accepted.map((file) => ({
                file,
                url: URL.createObjectURL(file),
                name: file.name,
                size: file.size < 1048576 ? Math.max(1, Math.round(file.size / 1024)) + ' KB' : (file.size / 1048576).toFixed(1) + ' MB',
            }));

            if (this.multiple) {
                this.files = this.files.concat(picked);
            } else {
                this.files.forEach((f) => URL.revokeObjectURL(f.url));
                this.files = picked.slice(0, 1);
            }
            this.sync();
        },
        removeFile(index) {
            URL.revokeObjectURL(this.files[index].url);
            this.files.splice(index, 1);
            this.sync();
        },
        sync() {
            const dt = new DataTransfer();
            this.files.forEach((f) => dt.items.add(f.file));
            this.$refs.input.files = dt.files;
        },
        drop(event) {
            this.dragging = false;
            this.addFiles(event.dataTransfer.files);
        },
        get removedCount() { return this.existing.filter((i) => i.removed).length; },
        get keptCount() { return this.existing.length - this.removedCount; },
        get isEmpty() { return this.multiple ? (this.existing.length === 0 && this.files.length === 0) : (!this.current && this.files.length === 0); },
    }"
    x-on:dragover.prevent="dragging = true"
    x-on:dragleave.self="dragging = false"
    x-on:drop.prevent="drop($event)"
>
    <div class="flex items-baseline justify-between gap-3">
        <label for="{{ $inputId }}" class="text-sm font-semibold tracking-wider block">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
        @if($multiple)
            <span x-show="!isEmpty" x-cloak class="text-xs text-brand-black/50"
                x-text="(keptCount + files.length) + (keptCount + files.length === 1 ? ' image' : ' images')"></span>
        @endif
    </div>

    {{-- The input that actually submits. Never clicked directly. --}}
    <input type="file" name="{{ $name }}" accept="{{ $accept }}" @if($multiple) multiple @endif x-ref="input" class="hidden" tabindex="-1" aria-hidden="true">

    {{-- The picker. Unnamed, so it never submits; each pick is copied into `files`. --}}
    <input type="file" id="{{ $inputId }}" accept="{{ $accept }}" @if($multiple) multiple @endif x-ref="picker" class="sr-only"
        x-on:change="addFiles($event.target.files); $event.target.value = ''">

    {{-- Removal markers for saved gallery images --}}
    <template x-for="image in existing.filter((i) => i.removed)" :key="'rm' + image.id">
        <input type="hidden" name="{{ $removeName }}" :value="image.id">
    </template>

    {{-- Empty: drop zone --}}
    <label for="{{ $inputId }}" x-show="isEmpty"
        :class="dragging ? 'border-primary bg-primary/10' : (requiredError ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 hover:bg-gray-100 hover:border-gray-300')"
        class="block cursor-pointer border-2 border-dashed rounded-3xl p-8 text-center transition">
        <span class="w-12 h-12 mx-auto rounded-2xl bg-primary/20 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-brand-black/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </span>
        <span class="block text-sm font-semibold">
            <span class="underline decoration-primary decoration-2 underline-offset-4">Choose {{ $multiple ? 'images' : 'an image' }}</span>
            <span class="font-normal text-brand-black/60">or drag {{ $multiple ? 'them' : 'it' }} here</span>
        </span>
        <span class="block text-xs text-brand-black/50 mt-1">{{ $help ? $help.' · ' : '' }}JPG, PNG, WebP · max {{ (int) $maxSizeMb }}MB {{ $multiple ? 'each' : '' }}</span>
    </label>

    @unless($multiple)
        {{-- Single: one large preview with explicit actions --}}
        <div x-show="!isEmpty" x-cloak
            :class="dragging ? 'ring-2 ring-primary' : ''"
            class="rounded-3xl border border-gray-200 bg-white overflow-hidden">
            <div class="relative bg-gray-100">
                <img :src="files.length ? files[0].url : current" alt="" class="w-full aspect-video object-cover">
                <span x-show="files.length && current" class="absolute top-3 left-3 rounded-full bg-primary px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-brand-black">New · replaces current on save</span>
                <span x-show="!files.length && current" class="absolute top-3 left-3 rounded-full bg-white/90 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-brand-black">Current</span>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3 border-t border-gray-100">
                <p class="text-xs text-brand-black/60 min-w-0 truncate">
                    <template x-if="files.length"><span><span class="font-semibold text-brand-black" x-text="files[0].name"></span> · <span x-text="files[0].size"></span></span></template>
                    <template x-if="!files.length"><span>Saved image. Leave as is to keep it.</span></template>
                </p>
                <div class="flex items-center gap-2 shrink-0">
                    <label for="{{ $inputId }}" class="cursor-pointer inline-flex items-center gap-1.5 rounded-full border border-brand-black/20 px-4 py-2 text-xs font-semibold uppercase tracking-wider hover:bg-gray-50 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Replace
                    </label>
                    <button type="button" x-show="files.length" x-on:click="removeFile(0)"
                        class="inline-flex items-center gap-1.5 rounded-full border border-red-200 text-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider hover:bg-red-50 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span x-text="current ? 'Keep current' : 'Remove'"></span>
                    </button>
                </div>
            </div>
        </div>
    @else
        {{-- Multiple: saved + new images in one grid --}}
        <div x-show="!isEmpty" x-cloak
            :class="dragging ? 'border-primary bg-primary/10' : 'border-gray-200 bg-gray-50'"
            class="rounded-3xl border-2 border-dashed p-3 sm:p-4 transition">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                <template x-for="image in existing" :key="'ex' + image.id">
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-white shadow-sm">
                        <img :src="image.url" alt="Saved gallery image" loading="lazy" class="w-full h-full object-cover transition" :class="image.removed ? 'grayscale opacity-40' : ''">
                        <span x-show="!image.removed" class="absolute bottom-2 left-2 rounded-full bg-white/90 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-brand-black/70">Saved</span>
                        <button type="button" x-show="!image.removed" x-on:click="image.removed = true"
                            class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/95 text-brand-black shadow hover:bg-red-600 hover:text-white flex items-center justify-center transition"
                            aria-label="Remove this image" title="Remove this image">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                        <div x-show="image.removed" class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-red-600/15 p-2 text-center">
                            <span class="rounded-full bg-red-600 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Removed on save</span>
                            <button type="button" x-on:click="image.removed = false" class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-brand-black shadow hover:bg-gray-100">Undo</button>
                        </div>
                    </div>
                </template>

                <template x-for="(item, index) in files" :key="item.url">
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-white shadow-sm">
                        <img :src="item.url" :alt="item.name" class="w-full h-full object-cover">
                        <span class="absolute bottom-2 left-2 rounded-full bg-primary px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-brand-black">New</span>
                        <button type="button" x-on:click="removeFile(index)"
                            class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/95 text-brand-black shadow hover:bg-red-600 hover:text-white flex items-center justify-center transition"
                            :aria-label="'Remove ' + item.name" :title="'Remove ' + item.name">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>

                <label for="{{ $inputId }}" class="aspect-square rounded-2xl border-2 border-dashed border-brand-black/15 bg-white hover:border-primary hover:bg-primary/10 flex flex-col items-center justify-center gap-1 cursor-pointer transition">
                    <svg class="w-6 h-6 text-brand-black/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-xs font-semibold text-brand-black/70">Add images</span>
                </label>
            </div>

            <p x-show="files.length || removedCount" class="mt-3 text-xs text-brand-black/60">
                <span x-show="files.length" x-text="files.length + (files.length === 1 ? ' new image' : ' new images') + ' will upload'"></span><span x-show="files.length && removedCount"> · </span><span x-show="removedCount" class="text-red-600 font-semibold" x-text="removedCount + (removedCount === 1 ? ' image' : ' images') + ' will be removed'"></span>
                when you save.
            </p>
        </div>
    @endunless

    <p x-show="requiredError" x-cloak class="text-red-500 text-xs font-semibold">Please add an image — this one is required.</p>
    <p x-show="sizeError" x-cloak x-text="sizeError" class="text-amber-600 text-xs font-semibold"></p>

    @if($errors->any() && ! $errors->has($errorKey) && ! $errors->has($errorKey.'.*'))
        {{-- Browsers can't refill file inputs after a failed save. --}}
        <p class="text-amber-600 text-xs">The form didn't save, so any image you picked here needs to be added again.</p>
    @endif
    @error($errorKey) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    @error($errorKey.'.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
