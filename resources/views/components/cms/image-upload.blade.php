@props([
    'name',
    'label',
    'multiple' => false,
    'accept' => 'image/*',
    'required' => false,
    'help' => null,
    'maxSizeMb' => 5,
])

{{--
    2026-09-04: replaces the CMS's previous file inputs, which were an
    invisible (opacity-0) overlay over a static icon with zero feedback
    after a file was actually picked — used on property, announcement, and
    team-member forms. This shows a real thumbnail immediately (FileReader),
    supports multiple files for galleries, and lets staff remove a picked
    file before submitting — the removal rebuilds the underlying input's
    FileList via DataTransfer, so a removed file is genuinely excluded from
    the upload, not just hidden.

    Also enforces `maxSizeMb` (default 5, matching every controller's own
    `max:5120` validation rule) client-side, at selection time — added the
    same day a real upload hit `PostTooLargeException` because PHP's
    upload_max_filesize/post_max_size were smaller than what the app's own
    validation promised. An oversized file is rejected here, before it's
    even attached to the form, with a plain-language message — the server
    can never be asked to accept something it was always going to reject.

    Deliberately self-contained (inline x-data, no separate JS module) —
    matches how Alpine is used everywhere else in this codebase (inquiry
    forms, property gallery lightbox, etc.), rather than introducing a new
    build entry for one small piece of behavior.
--}}
<div class="space-y-3"
    x-data="{
        multiple: {{ $multiple ? 'true' : 'false' }},
        maxBytes: {{ (int) ($maxSizeMb * 1024 * 1024) }},
        maxMb: {{ (int) $maxSizeMb }},
        previews: [],
        sizeError: null,
        addFiles(fileList) {
            this.sizeError = null;
            const incoming = Array.from(fileList).filter((f) => f.type.startsWith('image/'));
            const oversized = incoming.filter((f) => f.size > this.maxBytes);
            const accepted = incoming.filter((f) => f.size <= this.maxBytes);

            if (oversized.length) {
                const names = oversized.map((f) => f.name).join(', ');
                this.sizeError = oversized.length === 1
                    ? `“${names}” is over the ${this.maxMb}MB limit and wasn’t added.`
                    : `${oversized.length} files are over the ${this.maxMb}MB limit and weren’t added: ${names}.`;
            }

            const existing = this.multiple ? Array.from(this.$refs.input.files) : [];
            const combined = existing.concat(accepted);

            const dt = new DataTransfer();
            combined.forEach((f) => dt.items.add(f));
            this.$refs.input.files = dt.files;

            if (!this.multiple) { this.previews = []; }
            accepted.forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => this.previews.push({ src: e.target.result, name: file.name });
                reader.readAsDataURL(file);
            });
        },
        removePreview(index) {
            const dt = new DataTransfer();
            Array.from(this.$refs.input.files).forEach((file, i) => { if (i !== index) dt.items.add(file); });
            this.$refs.input.files = dt.files;
            this.previews.splice(index, 1);
        },
    }"
>
    <label class="text-sm font-semibold tracking-wider block">{{ $label }}</label>

    <div class="relative group">
        <input
            type="file"
            name="{{ $name }}"
            accept="{{ $accept }}"
            @if($multiple) multiple @endif
            @if($required) required @endif
            x-ref="input"
            x-show="previews.length === 0"
            x-on:change="addFiles($event.target.files)"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
        >

        <div x-show="previews.length === 0" class="border-2 border-dashed border-gray-200 rounded-3xl p-8 text-center bg-gray-50 group-hover:bg-gray-100 transition">
            <div class="w-12 h-12 mx-auto rounded-2xl bg-primary/20 flex items-center justify-center mb-2">
                <svg class="w-6 h-6 text-brand-black/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <p class="text-sm font-semibold">{{ $label }}</p>
            <p class="text-xs text-brand-black/50 mt-1">{{ $help ? $help.' · ' : '' }}Max {{ (int) $maxSizeMb }}MB per image</p>
        </div>

        <div x-show="previews.length > 0" x-cloak class="grid grid-cols-3 sm:grid-cols-4 gap-3 border-2 border-dashed border-primary/30 rounded-3xl p-4 bg-primary/5">
            <template x-for="(preview, index) in previews" :key="index">
                <div class="relative aspect-square rounded-2xl overflow-hidden border border-white shadow-sm">
                    <img :src="preview.src" :alt="preview.name" class="w-full h-full object-cover">
                    <button
                        type="button"
                        x-on:click.stop.prevent="removePreview(index)"
                        class="absolute top-1 right-1 z-20 w-6 h-6 rounded-full bg-brand-black/70 hover:bg-red-600 text-white flex items-center justify-center transition"
                        aria-label="Remove image"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </template>
            <label class="relative aspect-square rounded-2xl border-2 border-dashed border-primary/40 flex items-center justify-center cursor-pointer hover:bg-primary/10 transition" x-show="multiple">
                <span class="text-2xl text-brand-black/40 font-light">+</span>
                <input type="file" accept="{{ $accept }}" multiple class="absolute inset-0 opacity-0 cursor-pointer" x-on:change="addFiles($event.target.files); $event.target.value = '';">
            </label>
        </div>
    </div>

    <p x-show="sizeError" x-cloak x-text="sizeError" class="text-amber-600 text-xs font-semibold"></p>

    @php $errorKey = rtrim($name, '[]'); @endphp
    @error($errorKey) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    @error($errorKey.'.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
