@props([
    'active' => true,
    'activeLabel' => 'Visible',
    'inactiveLabel' => 'Hidden',
    'activeIcon' => 'eye',
    'inactiveIcon' => 'eye-off',
])

<span {{ $attributes->class([
        'inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap',
        'bg-primary/15 border border-primary/30 text-yellow-800' => $active,
        'bg-gray-100 text-gray-600' => ! $active,
    ]) }}>
    <i data-lucide="{{ $active ? $activeIcon : $inactiveIcon }}" class="w-3.5 h-3.5"></i>
    {{ $active ? $activeLabel : $inactiveLabel }}
</span>
