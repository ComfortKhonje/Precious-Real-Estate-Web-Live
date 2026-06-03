<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PREC CMS')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Alpine.js for CMS interactions --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-body text-brand-black cms-shell antialiased min-h-screen"
      x-data="{ sidebarOpen: false, userMenuOpen: false }">
    <div class="min-h-screen flex">
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-brand-black/40 lg:hidden"
             @click="sidebarOpen = false" aria-hidden="true"></div>

        {{-- Sidebar --}}
        <aside
            class="fixed z-50 inset-y-0 left-0 w-72 bg-brand-black text-white transform transition-transform duration-300 lg:translate-x-0 lg:flex lg:flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="h-20 px-6 flex items-center justify-between border-b border-white/10">
                <a href="{{ route('cms.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary text-brand-black flex items-center justify-center">
                        <x-cms.icon name="building-estate" class="w-5 h-5" />
                    </div>
                    <div class="leading-tight">
                        <div class="font-heading text-2xl">PREC CMS</div>
                        <div class="text-xs text-white/60 tracking-wider uppercase">Admin</div>
                    </div>
                </a>
                <button type="button" class="lg:hidden p-2 rounded-lg hover:bg-white/10" @click="sidebarOpen = false" aria-label="Close sidebar">
                    <x-cms.icon name="x" class="w-6 h-6" />
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-1">
                @php
                    $nav = [
                        ['label' => 'Dashboard Overview', 'route' => 'cms.dashboard', 'icon' => 'layout-dashboard', 'match' => 'cms.dashboard'],
                        ['label' => 'Property Listings', 'route' => 'cms.properties.index', 'icon' => 'building-estate', 'match' => 'cms.properties.*'],
                        ['label' => 'Featured Properties', 'route' => 'cms.featured.index', 'icon' => 'star', 'match' => 'cms.featured.*'],
                        ['label' => 'Services Content', 'route' => 'cms.services.index', 'icon' => 'briefcase', 'match' => 'cms.services.*'],
                        ['label' => 'Inquiries', 'route' => 'cms.inquiries.index', 'icon' => 'mail', 'match' => 'cms.inquiries.*'],
                        ['label' => 'Announcements & News', 'route' => 'cms.announcements.index', 'icon' => 'news', 'match' => 'cms.announcements.*'],
                        ['label' => 'Contact Information', 'route' => 'cms.contact.index', 'icon' => 'phone', 'match' => 'cms.contact.*'],
                        ['label' => 'Analytics', 'route' => 'cms.analytics.index', 'icon' => 'chart-bar', 'match' => 'cms.analytics.*'],
                        ['label' => 'Settings', 'route' => 'cms.settings.index', 'icon' => 'settings', 'match' => 'cms.settings.*'],
                    ];
                @endphp

                @foreach($nav as $item)
                    @php $isActive = request()->routeIs($item['match']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
                              {{ $isActive ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="w-10 h-10 rounded-2xl flex items-center justify-center {{ $isActive ? 'bg-primary text-brand-black' : 'bg-white/5 text-white/70' }}">
                            <x-cms.icon :name="$item['icon']" class="w-5 h-5" />
                        </span>
                        <span class="font-medium tracking-wide">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-6 py-6 border-t border-white/10">
                <div class="flex items-start gap-3 text-xs text-white/60 leading-relaxed">
                    <span class="w-9 h-9 rounded-2xl bg-white/5 flex items-center justify-center text-primary shrink-0">
                        <x-cms.icon name="shield-lock" class="w-4 h-4" />
                    </span>
                    <div>
                        Secure access only. Use strong passwords and limit CMS access to authorized staff.
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 lg:pl-72">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 bg-brand-white/85 backdrop-blur-xl border-b border-gray-200/70">
                <div class="h-20 px-6 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button type="button" class="lg:hidden p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition"
                                @click="sidebarOpen = true" aria-label="Open sidebar">
                            <x-cms.icon name="menu-2" class="w-6 h-6 text-brand-black" />
                        </button>
                        <div>
                            <div class="font-heading text-3xl leading-none">@yield('page_title', 'Dashboard')</div>
                            <div class="text-sm text-brand-black/60">@yield('page_subtitle', 'Manage site content and listings.')</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full border border-gray-200 text-sm font-semibold hover:bg-gray-50 transition">
                            <x-cms.icon name="eye" class="w-4 h-4" />
                            View Website
                        </a>

                        <div class="relative">
                            <button type="button" @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-3 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 transition" aria-label="User menu">
                                <div class="w-9 h-9 rounded-full bg-primary text-brand-black flex items-center justify-center">
                                    <x-cms.icon name="user-circle" class="w-5 h-5" />
                                </div>
                                <div class="hidden sm:block text-left leading-tight">
                                    <div class="text-sm font-semibold text-brand-black">Admin</div>
                                    <div class="text-xs text-brand-black/60">PREC Staff</div>
                                </div>
                                <x-cms.icon name="arrow-right" class="w-4 h-4 text-brand-black/70 rotate-90" />
                            </button>

                            <div x-show="userMenuOpen" @click.outside="userMenuOpen = false" x-transition
                                 class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
                                <a href="{{ route('cms.settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold hover:bg-gray-50">
                                    <x-cms.icon name="settings" class="w-4 h-4" />
                                    Settings
                                </a>
                                <div class="h-px bg-gray-100"></div>
                                <form method="POST" action="{{ route('cms.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50 flex items-center gap-3">
                                        <x-cms.icon name="logout" class="w-4 h-4" />
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="px-6 py-8">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 text-green-700 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <x-cms.icon name="circle-check" class="w-5 h-5" />
                            <span class="font-semibold">{{ session('success') }}</span>
                        </div>
                        <button type="button" @click="$el.parentElement.remove()" class="p-1 hover:bg-green-100 rounded-lg transition">
                            <x-cms.icon name="x" class="w-4 h-4" />
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-700 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <x-cms.icon name="circle-x" class="w-5 h-5" />
                            <span class="font-semibold">{{ session('error') }}</span>
                        </div>
                        <button type="button" @click="$el.parentElement.remove()" class="p-1 hover:bg-red-100 rounded-lg transition">
                            <x-cms.icon name="x" class="w-4 h-4" />
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
