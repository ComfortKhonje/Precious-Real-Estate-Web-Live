@props([
    'icon' => 'inbox',
    'title',
    'description' => null,
    'actionRoute' => null,
    'actionLabel' => null,
    'actionIcon' => 'plus',
])

<div class="bg-white border border-gray-100 rounded-3xl p-12 text-center">
    <div class="w-20 h-20 mx-auto rounded-full bg-primary/20 flex items-center justify-center text-primary mb-4">
        <i data-lucide="{{ $icon }}" class="w-10 h-10"></i>
    </div>
    <h3 class="font-heading text-2xl font-semibold text-brand-black mb-2">{{ $title }}</h3>
    @if($description)
        <p class="text-brand-black/60 mb-6 max-w-xl mx-auto">{{ $description }}</p>
    @endif
    @if($actionRoute)
        <a href="{{ $actionRoute }}" class="btn-primary inline-flex items-center gap-2">
            <i data-lucide="{{ $actionIcon }}" class="w-4 h-4"></i> {{ $actionLabel ?? 'Add New' }}
        </a>
    @endif
</div>
