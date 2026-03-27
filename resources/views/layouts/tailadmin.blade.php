<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'Portfolio') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    @stack('styles')

    <style>
        :root {
            --brand: #F16529;
            --brand-hover: #d65420;
            --surface: #ffffff;
            --surface-muted: #fff7f2;
            --border: #e5e7eb;
            --text-soft: #6b7280;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #fff7f2 0%, #ffffff 16%, #f8fafc 100%);
        }
        .font-display { font-family: 'Playfair Display', serif; }
        .bg-brand { background-color: var(--brand) !important; }
        .text-brand { color: var(--brand) !important; }
        .border-brand { border-color: var(--brand) !important; }
        .bg-brand-subtle { background-color: rgba(241, 101, 41, 0.08) !important; }
        .hover\:bg-brand-hover:hover { background-color: var(--brand-hover) !important; }
        .ring-brand { --tw-ring-color: var(--brand) !important; }
        [x-cloak] { display: none !important; }

        /* Custom cursor */
        @media (pointer: fine) {
            body, body a, body button, body input, body textarea, body select, body label {
                cursor: none !important;
            }
            .cursor-dot {
                position: fixed;
                width: 8px;
                height: 8px;
                background-color: var(--brand);
                border-radius: 999px;
                left: 0;
                top: 0;
                pointer-events: none;
                z-index: 100001;
                box-shadow: 0 0 0 6px rgba(241, 101, 41, 0.14);
                transition: transform 0.18s ease, opacity 0.18s ease;
            }
            .cursor-ring {
                position: fixed;
                width: 34px;
                height: 34px;
                border: 1.5px solid rgba(241, 101, 41, 0.55);
                border-radius: 999px;
                left: 0;
                top: 0;
                pointer-events: none;
                z-index: 100000;
                transition: width 0.18s ease, height 0.18s ease, opacity 0.18s ease, border-color 0.18s ease;
            }
            .cursor-dot.is-active { transform: scale(1.6); }
            .cursor-ring.is-active {
                width: 48px;
                height: 48px;
                border-color: rgba(241, 101, 41, 0.9);
            }
        }
        .cursor-label { display: none; }

        /* Sidebar */
        #sidebar {
            background-color: rgba(255, 255, 255, 0.94);
            border-color: var(--border);
            box-shadow: 20px 0 60px -40px rgba(15, 23, 42, 0.25);
            backdrop-filter: blur(16px);
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .menu-item-active {
            background-color: var(--brand);
            color: #111827 !important;
            font-weight: 600;
            box-shadow: 0 16px 32px -24px rgba(241, 101, 41, 0.95);
        }
        .menu-item-inactive {
            color: var(--text-soft);
        }
        .menu-item-inactive:hover {
            background-color: rgba(241, 101, 41, 0.08);
            color: #111827;
        }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }

        /* Dark mode */
        html.dark body {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 16%, #0f172a 100%) !important;
            color: #e2e8f0;
        }
        html.dark #sidebar {
            background-color: rgba(15, 23, 42, 0.94) !important;
            border-color: #334155 !important;
            box-shadow: 20px 0 60px -40px rgba(0, 0, 0, 0.5) !important;
        }
        html.dark header {
            background: rgba(15, 23, 42, 0.8) !important;
            border-color: #334155 !important;
        }
        html.dark .menu-item-inactive { color: #94a3b8; }
        html.dark .menu-item-inactive:hover {
            background-color: rgba(241, 101, 41, 0.15);
            color: #f1f5f9;
        }
        html.dark .menu-item-active { color: #fff !important; }
        html.dark .rounded-xl.border { border-color: #334155; }
        html.dark .bg-white\/80 { background: rgba(15, 23, 42, 0.8) !important; }
        html.dark .text-slate-950 { color: #f1f5f9; }
        html.dark .text-gray-500 { color: #94a3b8; }
        html.dark .border-gray-200 { border-color: #334155; }
        html.dark .text-gray-700 { color: #cbd5e1; }
        html.dark .bg-green-50 { background-color: rgba(34, 197, 94, 0.1); }
        html.dark .bg-red-50 { background-color: rgba(239, 68, 68, 0.1); }
        html.dark .hover\:bg-orange-50:hover { background-color: rgba(241, 101, 41, 0.15) !important; }
        html.dark .bg-white { background-color: #1e293b !important; }
        html.dark .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0,0,0,0.4) !important; }
        html.dark .hover\:bg-red-50:hover { background-color: rgba(239, 68, 68, 0.15) !important; }
    </style>

    <script>
        (function() {
            var theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') document.documentElement.classList.add('dark');
            else document.documentElement.classList.remove('dark');
        })();
    </script>
</head>
<body class="bg-transparent text-slate-950"
      x-data
      x-init="
        Alpine.store('sidebar', {
            isExpanded: window.innerWidth >= 1280,
            isHovered: false,
            isMobileOpen: false,
            get isOpen() { return this.isExpanded || this.isHovered || this.isMobileOpen; },
            toggleExpanded() { this.isExpanded = !this.isExpanded; },
            toggleMobileOpen() { this.isMobileOpen = !this.isMobileOpen; },
            setHovered(val) { if (!this.isExpanded && window.innerWidth >= 1280) this.isHovered = val; }
        });
        Alpine.store('theme', {
            mode: localStorage.getItem('theme') || 'light',
            toggle() {
                this.mode = this.mode === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', this.mode);
                if (this.mode === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
      ">

    {{-- Custom cursor --}}
    <div id="cursor-dot" class="cursor-dot"></div>
    <div id="cursor-ring" class="cursor-ring"></div>
    <div id="cursor-label" class="cursor-label"></div>

    <div class="flex min-h-screen">

        <!-- ═══════ SIDEBAR ═══════ -->
        <aside id="sidebar"
            class="fixed left-0 top-0 flex flex-col h-screen px-5 transition-all duration-300 ease-in-out z-[99999] border-r border-gray-200"
            :class="{
                'w-[280px]': $store.sidebar.isOpen,
                'w-[80px]': !$store.sidebar.isOpen,
                'translate-x-0': $store.sidebar.isMobileOpen,
                '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
            }"
            @mouseenter="$store.sidebar.setHovered(true)"
            @mouseleave="$store.sidebar.setHovered(false)">

            <!-- Logo -->
            <div class="pt-7 pb-6 flex"
                :class="!$store.sidebar.isOpen ? 'xl:justify-center' : 'justify-start'">
                <a href="/" class="flex items-center gap-2.5">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand">
                        <svg class="h-5 w-5 text-[#0C0C0C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20M2 12h20"/>
                        </svg>
                    </span>
                    <span x-show="$store.sidebar.isOpen" class="text-lg font-bold text-slate-950 font-display tracking-tight">Portfolio Admin</span>
                </a>
            </div>

            <!-- Nav Menu -->
            <nav class="flex flex-col overflow-y-auto flex-1 pb-4">
                <div class="flex flex-col gap-5">
                    <!-- Main -->
                    <div>
                        <h2 class="mb-3 text-[0.65rem] uppercase tracking-[0.2em] flex text-gray-500"
                            :class="!$store.sidebar.isOpen ? 'lg:justify-center' : 'justify-start'">
                            <span x-show="$store.sidebar.isOpen">Menu</span>
                            <svg x-show="!$store.sidebar.isOpen" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="6" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/>
                            </svg>
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   class="menu-item {{ request()->routeIs('dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.projects.create') }}"
                                   class="menu-item {{ request()->routeIs('dashboard.projects.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Soumettre un projet</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('vitrine') }}"
                                   class="menu-item menu-item-inactive"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h14a1 1 0 001-1V10"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Voir la vitrine</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Admin Section -->
                    @if(auth()->user()->isAdmin())
                    <div>
                        <h2 class="mb-3 text-[0.65rem] uppercase tracking-[0.2em] flex text-gray-500"
                            :class="!$store.sidebar.isOpen ? 'lg:justify-center' : 'justify-start'">
                            <span x-show="$store.sidebar.isOpen">Administration</span>
                            <svg x-show="!$store.sidebar.isOpen" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="6" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/>
                            </svg>
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a href="{{ route('dashboard') }}#moderation"
                                   class="menu-item menu-item-inactive"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Validation projets</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif

                    <!-- Account -->
                    <div>
                        <h2 class="mb-3 text-[0.65rem] uppercase tracking-[0.2em] flex text-gray-500"
                            :class="!$store.sidebar.isOpen ? 'lg:justify-center' : 'justify-start'">
                            <span x-show="$store.sidebar.isOpen">Compte</span>
                            <svg x-show="!$store.sidebar.isOpen" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="6" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/>
                            </svg>
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                   class="menu-item {{ request()->routeIs('profile.edit') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Mon profil</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Sidebar Mobile Backdrop -->
        <div x-show="$store.sidebar.isMobileOpen"
             @click="$store.sidebar.isMobileOpen = false"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[99998] xl:hidden"
             x-transition.opacity></div>

        <!-- ═══════ CONTENT AREA ═══════ -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden transition-all duration-300"
             :class="{
                'xl:ml-[280px]': $store.sidebar.isOpen,
                'xl:ml-[80px]': !$store.sidebar.isOpen
             }">

            <!-- Header -->
            <header class="sticky top-0 w-full z-[9999] border-b border-gray-200 bg-white/80 backdrop-blur-xl">
                <div class="flex items-center justify-between px-4 py-3 xl:px-6 lg:py-4">
                    <div class="flex items-center gap-3">
                        <!-- Desktop Toggle -->
                        <button @click="$store.sidebar.toggleExpanded()"
                                class="hidden xl:flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-500 hover:bg-orange-50 transition">
                            <svg width="16" height="12" viewBox="0 0 16 12" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.583 1C0.583 0.586 0.919 0.25 1.333 0.25H14.667C15.081 0.25 15.417 0.586 15.417 1C15.417 1.414 15.081 1.75 14.667 1.75H1.333C0.919 1.75 0.583 1.414 0.583 1ZM0.583 11C0.583 10.586 0.919 10.25 1.333 10.25H14.667C15.081 10.25 15.417 10.586 15.417 11C15.417 11.414 15.081 11.75 14.667 11.75H1.333C0.919 11.75 0.583 11.414 0.583 11ZM1.333 5.25C0.919 5.25 0.583 5.586 0.583 6C0.583 6.414 0.919 6.75 1.333 6.75H8C8.414 6.75 8.75 6.414 8.75 6C8.75 5.586 8.414 5.25 8 5.25H1.333Z" fill="currentColor"/>
                            </svg>
                        </button>

                        <!-- Mobile Toggle -->
                        <button @click="$store.sidebar.toggleMobileOpen()"
                                class="flex xl:hidden items-center justify-center w-10 h-10 rounded-xl text-gray-500 hover:bg-orange-50">
                            <svg x-show="!$store.sidebar.isMobileOpen" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.583 1C0.583 0.586 0.919 0.25 1.333 0.25H14.667C15.081 0.25 15.417 0.586 15.417 1C15.417 1.414 15.081 1.75 14.667 1.75H1.333C0.919 1.75 0.583 1.414 0.583 1ZM0.583 11C0.583 10.586 0.919 10.25 1.333 10.25H14.667C15.081 10.25 15.417 10.586 15.417 11C15.417 11.414 15.081 11.75 14.667 11.75H1.333C0.919 11.75 0.583 11.414 0.583 11ZM1.333 5.25C0.919 5.25 0.583 5.586 0.583 6C0.583 6.414 0.919 6.75 1.333 6.75H8C8.414 6.75 8.75 6.414 8.75 6C8.75 5.586 8.414 5.25 8 5.25H1.333Z" fill="currentColor"/>
                            </svg>
                            <svg x-show="$store.sidebar.isMobileOpen" width="20" height="20" viewBox="0 0 24 24" fill="none" style="display:none;">
                                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>

                        <!-- Mobile Logo -->
                        <a href="/" class="xl:hidden flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand">
                                <svg class="h-4 w-4 text-[#0C0C0C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20M2 12h20"/></svg>
                            </span>
                            <span class="text-base font-bold text-slate-950 font-display">Portfolio Admin</span>
                        </a>

                        <!-- Page Title -->
                        <h1 class="hidden xl:block text-lg font-semibold text-slate-950 font-display">@yield('title', 'Dashboard')</h1>
                    </div>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-3">
                        <!-- Theme Toggle -->
                        <button @click="$store.theme.toggle()"
                                class="flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-500 hover:bg-orange-50 transition">
                            <svg class="hidden dark:block w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg class="dark:hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>

                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2.5 text-sm">
                                <span class="hidden lg:block text-right">
                                    <span class="block font-medium text-slate-950">{{ Auth::user()->nom }}</span>
                                    <span class="block text-xs text-gray-500">{{ Auth::user()->email }}</span>
                                </span>
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-[#0C0C0C] font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->nom, 0, 2)) }}
                                </span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-3 w-56 rounded-2xl border border-gray-200 bg-white shadow-xl z-[99999]"
                                 x-cloak>
                                <div class="p-3 space-y-1 border-b border-gray-100">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-orange-50">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Mon Profil
                                    </a>
                                </div>
                                <div class="p-3">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-red-500 hover:bg-red-50">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="mx-auto w-full max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                @if(session('success'))
                    <div class="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Portail pour les modales (en dehors du conteneur overflow) --}}
    @stack('modals')

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @stack('scripts')

    <script>
        // Custom cursor tracking
        const cursorDot = document.getElementById('cursor-dot');
        const cursorRing = document.getElementById('cursor-ring');
        if (window.matchMedia('(pointer: fine)').matches && cursorDot && cursorRing) {
            let mouseX = window.innerWidth / 2;
            let mouseY = window.innerHeight / 2;
            let dotX = mouseX;
            let dotY = mouseY;

            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
                cursorRing.style.left = (mouseX - cursorRing.offsetWidth / 2) + 'px';
                cursorRing.style.top = (mouseY - cursorRing.offsetHeight / 2) + 'px';
            });

            function animateCursor() {
                dotX += (mouseX - dotX) * 0.3;
                dotY += (mouseY - dotY) * 0.3;
                cursorDot.style.left = (dotX - cursorDot.offsetWidth / 2) + 'px';
                cursorDot.style.top = (dotY - cursorDot.offsetHeight / 2) + 'px';
                requestAnimationFrame(animateCursor);
            }

            animateCursor();

            document.querySelectorAll('a, button, input, textarea, select, label').forEach((element) => {
                element.addEventListener('mouseenter', () => {
                    cursorDot.classList.add('is-active');
                    cursorRing.classList.add('is-active');
                });
                element.addEventListener('mouseleave', () => {
                    cursorDot.classList.remove('is-active');
                    cursorRing.classList.remove('is-active');
                });
            });

            document.addEventListener('mouseleave', () => {
                cursorDot.style.opacity = '0';
                cursorRing.style.opacity = '0';
            });

            document.addEventListener('mouseenter', () => {
                cursorDot.style.opacity = '1';
                cursorRing.style.opacity = '1';
            });
        } else {
            cursorDot?.remove();
            cursorRing?.remove();
        }
    </script>
</body>
</html>
