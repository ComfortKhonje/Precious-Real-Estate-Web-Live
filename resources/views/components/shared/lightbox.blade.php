@props(['title' => null])

{{--
    Shared in-page image viewer (2026-09-29). Replaces links that opened the
    raw image file in a new tab, which showed visitors the storage path.

    Open it from anywhere on the page:
        $dispatch('open-lightbox', { images: [url, ...], index: 0 })

    Keyboard: Esc closes, arrows step. Phones: swipe left/right, tap the
    backdrop to close. Right-click and drag are disabled on the enlarged
    image. That only discourages casual "save image"; any image a browser
    displays can still be downloaded.

    Teleported to <body>: <main> is its own stacking context (relative z-20),
    so rendered in place, even z-[100] sat underneath the sticky navbar.
--}}
<div x-data>
<template x-teleport="body">
<div x-data="{
        open: false,
        images: [],
        index: 0,
        touchX: null,
        show(detail) {
            this.images = detail.images || [];
            this.index = detail.index || 0;
            if (!this.images.length) return;
            this.open = true;
            document.documentElement.style.overflow = 'hidden';
            this.$nextTick(() => this.$refs.close.focus());
        },
        close() {
            this.open = false;
            document.documentElement.style.overflow = '';
        },
        next() { this.index = (this.index + 1) % this.images.length; },
        prev() { this.index = (this.index - 1 + this.images.length) % this.images.length; },
        swipeEnd(event) {
            if (this.touchX === null) return;
            const dx = event.changedTouches[0].clientX - this.touchX;
            if (Math.abs(dx) > 40 && this.images.length > 1) { dx < 0 ? this.next() : this.prev(); }
            this.touchX = null;
        },
    }"
    x-on:open-lightbox.window="show($event.detail)"
    x-on:keydown.escape.window="open && close()"
    x-on:keydown.arrow-right.window="open && next()"
    x-on:keydown.arrow-left.window="open && prev()"
    x-show="open"
    x-cloak
    x-transition.opacity.duration.200ms
    role="dialog"
    aria-modal="true"
    aria-label="{{ $title ? 'Photos: '.$title : 'Photo viewer' }}"
    class="fixed inset-0 z-[100] flex flex-col bg-brand-black/95 backdrop-blur-sm"
>
    {{-- Top bar --}}
    <div class="flex items-center justify-between gap-4 px-4 md:px-6 py-3 md:py-4 text-white">
        <div class="min-w-0">
            @if($title)
                <p class="text-xs font-bold uppercase tracking-[0.2em] truncate">{{ $title }}</p>
            @endif
            <p class="text-[11px] font-semibold uppercase tracking-widest text-white/50" x-show="images.length > 1">
                Photo <span x-text="index + 1"></span> of <span x-text="images.length"></span>
            </p>
        </div>
        <button type="button" x-ref="close" x-on:click="close()" aria-label="Close"
            class="shrink-0 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Image stage: tapping the empty area around the photo closes --}}
    <div class="relative flex-1 min-h-0 flex items-center justify-center px-2 md:px-20 pb-4"
        x-on:click.self="close()"
        x-on:touchstart.passive="touchX = $event.touches[0].clientX"
        x-on:touchend="swipeEnd($event)">
        <img :src="images[index]" alt="" draggable="false"
            x-on:contextmenu.prevent
            class="max-w-full max-h-full object-contain rounded-xl select-none shadow-2xl">

        <template x-if="images.length > 1">
            <div>
                <button type="button" x-on:click="prev()" aria-label="Previous photo"
                    class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white items-center justify-center transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" x-on:click="next()" aria-label="Next photo"
                    class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white items-center justify-center transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </template>
    </div>

    {{-- Dots on phones, where there are no arrow buttons --}}
    <div class="md:hidden flex justify-center gap-1.5 pb-6" x-show="images.length > 1">
        <template x-for="(img, i) in images" :key="i">
            <span class="h-1.5 rounded-full transition-all" :class="i === index ? 'w-5 bg-primary' : 'w-1.5 bg-white/30'"></span>
        </template>
    </div>
</div>
</template>
</div>
