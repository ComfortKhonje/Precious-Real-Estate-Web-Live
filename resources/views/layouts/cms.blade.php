<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PREC CMS')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Alpine.js for CMS interactions --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-body text-brand-black bg-brand-white antialiased min-h-screen"
      x-data="{ sidebarOpen: false, userMenuOpen: false }">
    <div class="min-h-screen flex">
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-brand-black/40 lg:hidden"
             @click="sidebarOpen = false" aria-hidden="true"></div>

        {{-- Sidebar --}}
        <aside
            class="fixed z-50 inset-y-0 left-0 w-72 bg-brand-black text-white transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="h-20 px-6 flex items-center justify-between border-b border-white/10">
                <a href="{{ route('cms.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary text-brand-black flex items-center justify-center font-heading text-xl">P</div>
                    <div class="leading-tight">
                        <div class="font-heading text-2xl">PREC CMS</div>
                        <div class="text-xs text-white/60 tracking-wider uppercase">Admin</div>
                    </div>
                </a>
                <button type="button" class="lg:hidden p-2 rounded-lg hover:bg-white/10" @click="sidebarOpen = false" aria-label="Close sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="px-3 py-6 space-y-1">
                @php
                    $nav = [
                        ['label' => 'Dashboard Overview', 'route' => 'cms.dashboard'],
                        ['label' => 'Property Listings', 'route' => 'cms.properties.index'],
                        ['label' => 'Featured Properties', 'route' => 'cms.featured.index'],
                        ['label' => 'Services Content', 'route' => 'cms.services.index'],
                        ['label' => 'Inquiries', 'route' => 'cms.inquiries.index'],
                        ['label' => 'Announcements & News', 'route' => 'cms.announcements.index'],
                        ['label' => 'Contact Information', 'route' => 'cms.contact.index'],
                        ['label' => 'Analytics', 'route' => 'cms.analytics.index'],
                        ['label' => 'Settings', 'route' => 'cms.settings.index'],
                    ];
                @endphp

                @foreach($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                              {{ request()->routeIs($item['route']) ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="w-2 h-2 rounded-full {{ request()->routeIs($item['route']) ? 'bg-primary' : 'bg-white/30' }}"></span>
                        <span class="font-medium tracking-wide">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-6 py-6 border-t border-white/10">
                <div class="text-xs text-white/60 leading-relaxed">
                    Secure access only. Use strong passwords.
                </div>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 lg:pl-0">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 bg-brand-white/90 backdrop-blur border-b border-gray-100">
                <div class="h-20 px-6 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button type="button" class="lg:hidden p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition"
                                @click="sidebarOpen = true" aria-label="Open sidebar">
                            <svg class="w-6 h-6 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <div class="font-heading text-3xl leading-none">@yield('page_title', 'Dashboard')</div>
                            <div class="text-sm text-brand-black/60">@yield('page_subtitle', 'Manage site content and listings.')</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2 rounded-full border border-gray-200 text-sm font-semibold hover:bg-gray-50 transition">
                            View Website
                        </a>

                        <div class="relative">
                            <button type="button" @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-3 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 transition" aria-label="User menu">
                                <div class="w-9 h-9 rounded-full bg-primary text-brand-black flex items-center justify-center font-bold">A</div>
                                <div class="hidden sm:block text-left leading-tight">
                                    <div class="text-sm font-semibold text-brand-black">Admin</div>
                                    <div class="text-xs text-brand-black/60">PREC Staff</div>
                                </div>
                                <svg class="w-4 h-4 text-brand-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                            <div x-show="userMenuOpen" @click.outside="userMenuOpen = false" x-transition
                                 class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
                                <a href="{{ route('cms.settings.index') }}" class="block px-4 py-3 text-sm font-semibold hover:bg-gray-50">Settings</a>
                                <div class="h-px bg-gray-100"></div>
                                <form method="POST" action="{{ route('cms.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="px-6 py-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
