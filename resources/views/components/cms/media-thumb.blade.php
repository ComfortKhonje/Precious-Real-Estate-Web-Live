@props([
    'src' => null,
    'alt' => '',
    'icon' => 'image',
    'aspect' => 'aspect-[4/3]',
])

{{--
    Shared image slot for CMS card grids (properties/services/announcements/
    team members). Shows a shimmer skeleton until the image actually
    finishes loading, then fades it in — avoids the blank/broken-looking
    flash these cards used to have while a photo was still downloading.

    x-init checks $refs.img.complete on load: Alpine's x-on:load listener
    attaches after DOMContentLoaded (script is `defer`), so an image the
    browser already had cached fires its native `load` event before Alpine
    ever binds the handler — without this check that image would sit at
    opacity-0 forever.

    Default slot = absolutely-positioned overlay content (badges, hover
    actions) stacked on top of the image. Named `fallback` slot lets a
    caller (e.g. services, which fall back to an icon image rather than a
    lucide glyph) override the default no-image placeholder.
--}}
<div {{ $attributes->class(['relative overflow-hidden bg-gray-100', $aspect]) }}
    x-data="{ loaded: false, errored: false }"
    x-init="if ($refs.img && $refs.img.complete && $refs.img.naturalWidth > 0) loaded = true">
    @if($src)
        <div x-show="!loaded && !errored" x-cloak class="absolute inset-0 animate-pulse bg-gradient-to-br from-gray-200 via-gray-100 to-gray-200"></div>
        <img x-ref="img" x-show="!errored" src="{{ $src }}" alt="{{ $alt }}" loading="lazy" decoding="async"
            x-on:load="loaded = true" x-on:error="errored = true"
            :class="loaded ? 'opacity-100' : 'opacity-0'"
            class="w-full h-full object-cover transition-opacity duration-300">
        <div x-show="errored" x-cloak class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-100">
            <i data-lucide="{{ $icon }}" class="w-10 h-10 text-brand-black/30"></i>
        </div>
    @else
        @isset($fallback)
            {{ $fallback }}
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/20 to-primary/10">
                <i data-lucide="{{ $icon }}" class="w-10 h-10 text-brand-black/30"></i>
            </div>
        @endisset
    @endif

    {{ $slot }}
</div>
