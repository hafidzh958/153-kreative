<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ═══════════════════════════════════════════
           iOS / iPhone Design System
        ═══════════════════════════════════════════ */
        :root {
            /* iOS System Colors */
            --ios-blue:     #007AFF;
            --ios-blue-dk:  #0055D4;
            --ios-blue-lt:  rgba(0, 122, 255, 0.12);
            --ios-indigo:   #5856D6;
            --ios-purple:   #AF52DE;
            --ios-pink:     #FF2D55;
            --ios-red:      #FF3B30;
            --ios-orange:   #FF9500;
            --ios-yellow:   #FFCC00;
            --ios-green:    #34C759;
            --ios-teal:     #5AC8FA;
            --ios-gray:     #8E8E93;
            --ios-gray2:    #C7C7CC;

            /* Backgrounds (iOS Light Mode) */
            --bg-primary:   #F2F2F7;
            --bg-secondary: #FFFFFF;
            --bg-tertiary:  #F2F2F7;

            /* Labels */
            --label:        #000000;
            --label-2:      rgba(60, 60, 67, 0.6);
            --label-3:      rgba(60, 60, 67, 0.3);
            --label-4:      rgba(60, 60, 67, 0.18);

            /* Separators */
            --sep:          rgba(60, 60, 67, 0.29);
            --sep-opaque:   #C6C6C8;

            /* Fills */
            --fill:         rgba(120, 120, 128, 0.2);
            --fill-2:       rgba(120, 120, 128, 0.16);
            --fill-3:       rgba(118, 118, 128, 0.12);
            --fill-4:       rgba(116, 116, 128, 0.08);

            /* Layout */
            --sidebar-w:    260px;
            --topbar-h:     52px;

            /* iOS corner radius */
            --r-xs:  6px;
            --r-sm:  10px;
            --r-md:  14px;
            --r-lg:  18px;
            --r-xl:  22px;
            --r-2xl: 28px;

            /* iOS Shadows */
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow:     0 4px 16px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04);
            --shadow-lg:  0 12px 40px rgba(0,0,0,0.12), 0 4px 12px rgba(0,0,0,0.06);
            --shadow-xl:  0 24px 64px rgba(0,0,0,0.16), 0 8px 24px rgba(0,0,0,0.08);

            /* Transitions */
            --spring: cubic-bezier(0.34, 1.56, 0.64, 1);
            --ease:   cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* Layout shell — do NOT reset margin/padding globally (conflicts with Tailwind) */
        html, body {
            height: 100%;
            overflow: hidden;  /* prevent body scroll — only #admin-content scrolls */
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Display', sans-serif;
            background: var(--bg-primary);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ── TOPBAR ──────────────────────────── */
        #admin-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--topbar-h);
            z-index: 300;
            background: rgba(242, 242, 247, 0.85);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 0.5px solid var(--sep-opaque);
            display: flex;
            align-items: center;
            padding: 0 16px;
            gap: 12px;
        }

        #sidebar-toggle {
            width: 36px;
            height: 36px;
            border-radius: var(--r-sm);
            border: none;
            background: var(--fill);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--ios-blue);
            transition: all 0.18s var(--ease);
            flex-shrink: 0;
        }
        #sidebar-toggle:hover { background: var(--fill-2); transform: scale(0.96); }
        #sidebar-toggle:active { transform: scale(0.90); }
        #sidebar-toggle svg { width: 18px; height: 18px; }

        .topbar-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--label);
            letter-spacing: -0.3px;
        }

        .topbar-spacer { flex: 1; }

        .topbar-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ios-blue);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: var(--r-sm);
            background: var(--ios-blue-lt);
            transition: all 0.18s var(--ease);
        }
        .topbar-action:hover { background: rgba(0,122,255,0.18); transform: scale(0.97); }
        .topbar-action:active { transform: scale(0.93); }
        .topbar-action svg { width: 13px; height: 13px; }

        /* ── SIDEBAR ─────────────────────────── */
        #admin-sidebar {
            position: fixed;
            left: 0;
            top: var(--topbar-h);
            width: var(--sidebar-w);
            height: calc(100vh - var(--topbar-h));
            z-index: 200;
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: saturate(180%) blur(24px);
            -webkit-backdrop-filter: saturate(180%) blur(24px);
            border-right: 0.5px solid var(--sep-opaque);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: width 0.28s var(--ease), transform 0.3s var(--ease);
        }

        #admin-sidebar.collapsed {
            width: 64px;
        }
        #admin-sidebar.collapsed .sidebar-label,
        #admin-sidebar.collapsed .sidebar-section-label,
        #admin-sidebar.collapsed .sidebar-footer-label {
            display: none;
        }
        #admin-sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        #admin-sidebar.collapsed .sidebar-section {
            padding-left: 0;
            padding-right: 0;
            text-align: center;
        }

        /* SIDEBAR NAV */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 10px;
            scrollbar-width: none;
        }
        .sidebar-nav::-webkit-scrollbar { width: 0; }

        /* Section header */
        .sidebar-section {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--label-3);
            padding: 14px 8px 5px;
            transition: all 0.28s var(--ease);
        }

        /* Nav link */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 10px;
            border-radius: var(--r-md);
            font-size: 14px;
            font-weight: 500;
            color: var(--label-2);
            text-decoration: none;
            transition: all 0.2s var(--ease);
            margin-bottom: 2px;
            position: relative;
            border: none;
            background: transparent;
            cursor: pointer;
            width: 100%;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-link:hover {
            background: var(--fill-4);
            color: var(--label);
        }

        .sidebar-link.active {
            background: var(--bg-secondary);
            color: var(--ios-blue);
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-link .link-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--r-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--fill-3);
            transition: all 0.2s var(--ease);
        }
        .sidebar-link .link-icon svg {
            width: 16px;
            height: 16px;
            transition: color 0.2s;
        }

        .sidebar-link.active .link-icon {
            background: var(--ios-blue);
            box-shadow: 0 4px 12px rgba(0,122,255,0.35);
        }
        .sidebar-link.active .link-icon svg {
            color: #fff;
        }
        .sidebar-link:hover:not(.active) .link-icon {
            background: var(--fill-2);
        }

        .sidebar-link .link-label {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 10px;
            border-top: 0.5px solid var(--sep-opaque);
            flex-shrink: 0;
        }

        /* ── MAIN CONTENT ─────────────────────── */
        #admin-content {
            margin-left: 260px;
            margin-left: var(--sidebar-w);
            margin-top: 52px;
            margin-top: var(--topbar-h);
            height: calc(100vh - 52px);
            height: calc(100vh - var(--topbar-h));
            overflow-y: auto;
            transition: margin-left 0.28s var(--ease);
        }
        #admin-content::-webkit-scrollbar { width: 4px; }
        #admin-content::-webkit-scrollbar-thumb { background: var(--sep-opaque); border-radius: 4px; }

        #admin-content.sidebar-collapsed {
            margin-left: 64px;
        }

        .admin-main {
            padding: 24px;
            min-height: calc(100vh - 52px);
            min-height: calc(100vh - var(--topbar-h));
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ── ALERTS ────────────────────────────── */
        .ios-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            border-radius: var(--r-md);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        .ios-alert svg { width: 18px; height: 18px; flex-shrink: 0; }
        .ios-alert-success { background: rgba(52, 199, 89, 0.12); color: #1B8C3A; }
        .ios-alert-error   { background: rgba(255, 59, 48, 0.1);  color: #CC3028; }

        /* ── MOBILE ────────────────────────────── */
        @media (max-width: 767px) {
            #admin-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w) !important;
                box-shadow: var(--shadow-xl);
            }
            #admin-sidebar.mobile-open {
                transform: translateX(0);
            }
            #admin-content {
                margin-left: 0 !important;
            }
            .admin-main {
                padding: 16px;
            }
        }

        /* ── BACKDROP ──────────────────────────── */
        #sidebar-backdrop {
            position: fixed;
            inset: 0;
            z-index: 150;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s var(--ease);
        }
        #sidebar-backdrop.visible {
            opacity: 1;
            pointer-events: all;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Mobile sidebar backdrop --}}
    <div id="sidebar-backdrop" aria-hidden="true"></div>

    {{-- ── Topbar ── --}}
    <header id="admin-topbar">
        <button type="button" id="sidebar-toggle" aria-label="Toggle sidebar">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>

        <span class="topbar-title">Admin Kreatif 153</span>

        <div class="topbar-spacer"></div>

        <a href="{{ route('home') }}" target="_blank" class="topbar-action hidden sm:inline-flex">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Lihat Website
        </a>
    </header>

    {{-- ── Sidebar ── --}}
    <aside id="admin-sidebar">
        <nav class="sidebar-nav">

            <div class="sidebar-section sidebar-section-label">Menu</div>

            <a href="{{ route('admin.home.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.home.*') ? 'active' : '' }}"
               title="Home">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.home.*') ? '2.5' : '1.8' }}" d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.home.*') ? '2.5' : '1.8' }}" d="M9 21V12h6v9"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Home</span>
            </a>

            <a href="{{ route('admin.about.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}"
               title="About">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.about.*') ? '2.5' : '1.8' }}" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">About</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
               title="Services">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.services.*') ? '2.5' : '1.8' }}" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 4h16M5 4l1 9a3 3 0 003 3h6a3 3 0 003-3l1-9"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Services</span>
            </a>

            <a href="{{ route('admin.portfolio.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}"
               title="Portfolio">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.portfolio.*') ? '2.5' : '1.8' }}" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Portfolio</span>
            </a>

            <a href="{{ route('admin.clients.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"
               title="Mitra">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.clients.*') ? '2.5' : '1.8' }}" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Mitra</span>
            </a>

            <a href="{{ route('admin.testimonials.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"
               title="Testimonial">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.testimonials.*') ? '2.5' : '1.8' }}" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Testimonial</span>
            </a>

            <a href="{{ route('admin.contact.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}"
               title="Contact">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.contact.*') ? '2.5' : '1.8' }}" d="M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72A7.962 7.962 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 11h.01M12 11h.01M16 11h.01"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Contact</span>
            </a>

            <a href="{{ route('admin.finance.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}"
               title="Finance">
                <span class="link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.finance.*') ? '2.5' : '1.8' }}" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Finance</span>
            </a>

        </nav>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <a href="{{ route('home') }}" target="_blank"
               class="sidebar-link sidebar-footer-label"
               title="Lihat Website">
                <span class="link-icon" style="background: rgba(52,199,89,0.12);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--ios-green);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label">Lihat Website</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="sidebar-link sidebar-footer-label" title="Keluar">
                    <span class="link-icon" style="background: rgba(255,59,48,0.1);">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--ios-red);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </span>
                    <span class="link-label sidebar-label" style="color: var(--ios-red); font-weight:600;">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main Content ── --}}
    <div id="admin-content">
        <main class="admin-main">

            @if(session('success'))
                <div class="ios-alert ios-alert-success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="ios-alert ios-alert-error">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
    (function () {
        var sidebar  = document.getElementById('admin-sidebar');
        var content  = document.getElementById('admin-content');
        var backdrop = document.getElementById('sidebar-backdrop');
        var toggle   = document.getElementById('sidebar-toggle');

        function isMobile() { return window.innerWidth < 768; }

        function openMobile() {
            sidebar.classList.add('mobile-open');
            backdrop.classList.add('visible');
        }
        function closeMobile() {
            sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('visible');
        }

        function toggleSidebar() {
            if (isMobile()) {
                sidebar.classList.contains('mobile-open') ? closeMobile() : openMobile();
            } else {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('sidebar-collapsed');
            }
        }

        if (toggle)   toggle.addEventListener('click', toggleSidebar);
        if (backdrop) backdrop.addEventListener('click', closeMobile);

        window.addEventListener('resize', function () {
            if (!isMobile()) closeMobile();
        });
    })();
    </script>

    @stack('scripts')
</body>
</html>
