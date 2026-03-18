<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ─── Admin Fixed Layout ───────────────────────────────── */
        body.admin-body {
            overflow: hidden;
        }
        #admin-topbar {
            height: 56px;
        }
        #admin-sidebar {
            width: 240px;
            top: 56px;
            height: calc(100vh - 56px);
            transition: width 0.25s ease, transform 0.25s ease;
        }
        #admin-sidebar.collapsed {
            width: 60px;
        }
        #admin-sidebar.collapsed .sidebar-label,
        #admin-sidebar.collapsed .sidebar-footer-label {
            display: none;
        }
        #admin-sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        #admin-sidebar.collapsed .sidebar-logo {
            display: none;
        }
        #admin-content {
            margin-left: 240px;
            margin-top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            transition: margin-left 0.25s ease;
        }
        #admin-content.sidebar-collapsed {
            margin-left: 60px;
        }
        /* Mobile overlay */
        @media (max-width: 767px) {
            #admin-sidebar {
                transform: translateX(-100%);
                width: 240px !important;
            }
            #admin-sidebar.mobile-open {
                transform: translateX(0);
            }
            #admin-content {
                margin-left: 0 !important;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="admin-body bg-slate-100 text-gray-900">

    {{-- Mobile sidebar backdrop --}}
    <div id="sidebar-backdrop" class="fixed inset-0 z-30 bg-black/50 opacity-0 pointer-events-none md:hidden transition-opacity" aria-hidden="true"></div>

    {{-- Topbar --}}
    @include('admin.components.navbar')

    {{-- Sidebar --}}
    @include('admin.components.sidebar')

    {{-- Main Content --}}
    <div id="admin-content">
        <main class="p-4 sm:p-6">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="mb-4 flex items-center gap-2 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 shadow-sm">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        @include('admin.components.footer')
    </div>

    <script>
        (function() {
            var sidebar = document.getElementById('admin-sidebar');
            var content = document.getElementById('admin-content');
            var backdrop = document.getElementById('sidebar-backdrop');
            var toggle  = document.getElementById('sidebar-toggle');
            var isMobile = function() { return window.innerWidth < 768; };

            function toggleSidebar() {
                if (isMobile()) {
                    // Mobile: slide in/out
                    sidebar.classList.toggle('mobile-open');
                    if (sidebar.classList.contains('mobile-open')) {
                        backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    } else {
                        backdrop.classList.add('opacity-0', 'pointer-events-none');
                    }
                } else {
                    // Desktop: collapse/expand
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('sidebar-collapsed');
                }
            }

            if (toggle) toggle.addEventListener('click', toggleSidebar);

            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                });
            }

            window.addEventListener('resize', function() {
                if (!isMobile()) {
                    sidebar.classList.remove('mobile-open');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
