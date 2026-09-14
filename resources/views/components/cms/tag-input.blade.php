@props([
    'name',
    'value' => '',
    'placeholder' => 'Type a value and press Enter…',
    'help' => null,
])

{{--
    Replaces a plain "comma-separated" text input for fields the backend
    already stores as an array (Property::features/nearby_amenities,
    Service::features) — each point used to be one long string the user
    had to type commas into by hand and re-read to see where one item
    ended and the next began. This renders each item as a removable pill
    instead, but still submits the exact same comma-joined string those
    controllers already parse (explode(',', ...)->map(trim)->filter()) —
    no backend change needed, this is purely the input's presentation.
--}}
<div class="space-y-2"
    x-data="{
        tags: {{ Js::from(collect(explode(',', $value))->map(fn ($t) => trim($t))->filter()->values()->all()) }},
        draft: '',
        commit() {
            const v = this.draft.trim();
            if (v && !this.tags.includes(v)) { this.tags.push(v); }
            this.draft = '';
        },
    }"
>
    <div class="cms-input flex flex-wrap gap-2 items-center py-2.5 cursor-text focus-within:ring-2 focus-within:ring-primary focus-within:bg-white focus-within:border-primary/20" @click="$refs.tagInputField.focus()">
        <template x-for="(tag, index) in tags" :key="index">
            <span class="inline-flex items-center gap-1.5 pl-3 pr-1.5 py-1 rounded-full bg-primary/20 text-brand-black text-sm font-semibold max-w-full">
                <span x-text="tag" class="truncate"></span>
                <button type="button" @click.stop="tags.splice(index, 1)" class="w-4 h-4 rounded-full hover:bg-brand-black/10 flex items-center justify-center shrink-0" aria-label="Remove">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </span>
        </template>
        <input type="text" x-ref="tagInputField" x-model="draft"
            @keydown.enter.prevent="commit()"
            @keydown.comma.prevent="commit()"
            @keydown.backspace="if (!draft && tags.length) tags.splice(tags.length - 1, 1)"
            @blur="commit()"
            placeholder="{{ $placeholder }}"
            class="flex-1 min-w-[140px] bg-transparent border-none outline-none focus:ring-0 p-0 text-sm">
    </div>
    <input type="hidden" name="{{ $name }}" :value="tags.join(', ')">
    @if($help)
        <p class="text-xs text-brand-black/50">{{ $help }}</p>
    @endif
    @error($name) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
