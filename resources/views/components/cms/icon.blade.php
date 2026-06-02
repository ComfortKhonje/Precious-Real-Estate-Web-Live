@props([
    'name',
    'class' => 'w-5 h-5',
    'stroke' => 1.8,
])

<svg {{ $attributes->merge(['class' => $class]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('layout-dashboard')
            <path d="M4 4h6v8H4z"/>
            <path d="M14 4h6v5h-6z"/>
            <path d="M14 13h6v7h-6z"/>
            <path d="M4 16h6v4H4z"/>
            @break
        @case('building-estate')
            <path d="M3 21h18"/>
            <path d="M5 21V7l7-4 7 4v14"/>
            <path d="M9 9h.01"/>
            <path d="M9 12h.01"/>
            <path d="M9 15h.01"/>
            <path d="M15 9h.01"/>
            <path d="M15 12h.01"/>
            <path d="M15 15h.01"/>
            @break
        @case('star')
            <path d="m12 3 2.9 5.88 6.5.95-4.7 4.58 1.11 6.49L12 17.77 6.19 20.9l1.11-6.49L2.6 9.83l6.5-.95z"/>
            @break
        @case('briefcase')
            <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            <path d="M4 9h16v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
            <path d="M4 13h16"/>
            @break
        @case('mail')
            <path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <path d="m4 8 8 5 8-5"/>
            @break
        @case('speakerphone')
            <path d="M14 8.5a4 4 0 0 1 0 7"/>
            <path d="M17 5a9 9 0 0 1 0 14"/>
            <path d="M4 10h4l5-4v12l-5-4H4z"/>
            @break
        @case('phone')
            <path d="M5 4h4l2 5-2.5 1.5a15 15 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A15 15 0 0 1 3 6a2 2 0 0 1 2-2"/>
            @break
        @case('chart-bar')
            <path d="M4 20V10"/>
            <path d="M10 20V4"/>
            <path d="M16 20v-7"/>
            <path d="M22 20v-11"/>
            <path d="M2 20h20"/>
            @break
        @case('settings')
            <path d="M12 9.5A2.5 2.5 0 1 1 12 14.5A2.5 2.5 0 0 1 12 9.5z"/>
            <path d="M19.4 15a1 1 0 0 0 .2 1.1l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1 1 0 0 0-1.1-.2 1 1 0 0 0-.6.9V20a2 2 0 1 1-4 0v-.2a1 1 0 0 0-.6-.9 1 1 0 0 0-1.1.2l-.1.1a2 2 0 0 1-2.8-2.8l.1-.1a1 1 0 0 0 .2-1.1 1 1 0 0 0-.9-.6H4a2 2 0 1 1 0-4h.2a1 1 0 0 0 .9-.6 1 1 0 0 0-.2-1.1l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1 1 0 0 0 1.1.2 1 1 0 0 0 .6-.9V4a2 2 0 1 1 4 0v.2a1 1 0 0 0 .6.9 1 1 0 0 0 1.1-.2l.1-.1a2 2 0 0 1 2.8 2.8l-.1.1a1 1 0 0 0-.2 1.1 1 1 0 0 0 .9.6H20a2 2 0 1 1 0 4h-.2a1 1 0 0 0-.9.6z"/>
            @break
        @case('arrow-right')
            <path d="M5 12h14"/>
            <path d="m13 6 6 6-6 6"/>
            @break
        @case('plus')
            <path d="M12 5v14"/>
            <path d="M5 12h14"/>
            @break
        @case('eye')
            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6"/>
            <path d="M12 9a3 3 0 1 0 0 6a3 3 0 0 0 0-6"/>
            @break
        @case('logout')
            <path d="M14 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2"/>
            <path d="M9 12h12"/>
            <path d="m17 8 4 4-4 4"/>
            @break
        @case('user-circle')
            <path d="M12 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8z"/>
            <path d="M6 20a6 6 0 0 1 12 0"/>
            <path d="M12 22a10 10 0 1 0 0-20a10 10 0 0 0 0 20z"/>
            @break
        @case('menu-2')
            <path d="M4 6h16"/>
            <path d="M4 12h16"/>
            <path d="M4 18h16"/>
            @break
        @case('x')
            <path d="M18 6 6 18"/>
            <path d="m6 6 12 12"/>
            @break
        @case('shield-lock')
            <path d="M12 3 5 6v6c0 5 3 8 7 9 4-1 7-4 7-9V6z"/>
            <path d="M10 11V9a2 2 0 1 1 4 0v2"/>
            <path d="M9 11h6v4H9z"/>
            @break
        @case('news')
            <path d="M5 6h11a2 2 0 0 1 2 2v10H7a2 2 0 0 1-2-2z"/>
            <path d="M5 18a2 2 0 1 1 0-4"/>
            <path d="M9 10h5"/>
            <path d="M9 13h6"/>
            @break
        @case('calendar-time')
            <path d="M16 3v4"/>
            <path d="M8 3v4"/>
            <path d="M4 11h16"/>
            <path d="M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z"/>
            <path d="M12 14v3l2 1"/>
            <path d="M12 11.5a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7z"/>
            @break
        @default
            <circle cx="12" cy="12" r="9"/>
    @endswitch
</svg>
