@props([
    'name',
    'checked' => false,
    'label' => null,
    'description' => null,
    'value' => '1',
])

{{--
    One toggle-switch look for every on/off field in the CMS forms —
    replaces three different widgets that all meant the same thing
    (Properties/Announcements' plain checkbox, Services/Team Members'
    pair of "Visible"/"Hidden" radio buttons). Renders a real checkbox
    (sr-only) so every controller's existing $request->boolean($name)
    read keeps working unchanged — unchecked simply omits the field,
    same as before.
--}}
<label {{ $attributes->class(['flex items-center justify-between gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer']) }}>
    @if($label)
        <div>
            <div class="font-semibold">{{ $label }}</div>
            @if($description)
                <div class="text-sm text-brand-black/60">{{ $description }}</div>
            @endif
        </div>
    @else
        <div>{{ $slot }}</div>
    @endif

    <span class="relative inline-flex shrink-0">
        <input type="checkbox" name="{{ $name }}" value="{{ $value }}" @checked($checked) class="peer sr-only">
        <span class="w-11 h-6 rounded-full bg-gray-300 peer-checked:bg-primary peer-focus-visible:ring-2 peer-focus-visible:ring-primary peer-focus-visible:ring-offset-2 transition-colors duration-200"></span>
        <span class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
    </span>
</label>
