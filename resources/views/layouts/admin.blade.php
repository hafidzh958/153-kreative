<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/153.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen bg-white text-gray-900 overflow-x-hidden">
    {{-- Mobile sidebar backdrop --}}
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 opacity-0 pointer-events-none md:hidden transition-opacity" aria-hidden="true"></div>

    <div class="flex min-h-screen">
        @include('admin.components.sidebar')

        <div class="flex-1 flex flex-col min-w-0 w-full">
            <header class="flex-shrink-0 border-b border-gray-200 bg-white px-4 sm:px-6 py-3 sm:py-4">
                <div class="flex items-center justify-between gap-4">
                    <button type="button" id="sidebar-toggle" class="md:hidden p-2 -ml-2 rounded-lg text-gray-600 hover:bg-gray-100" aria-label="Toggle menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-base sm:text-lg font-semibold text-gray-900 truncate">@yield('page-title', 'Dashboard')</h1>
                    <div class="hidden sm:flex items-center gap-2 text-xs text-gray-500 flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span>153 Kreatif Admin</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 bg-gray-50/50 min-h-0">
                <div class="max-w-5xl">
                    @if(session('success'))
                        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        (function() {
            var sidebar = document.getElementById('admin-sidebar');
            var backdrop = document.getElementById('sidebar-backdrop');
            var toggle = document.getElementById('sidebar-toggle');
            if (!sidebar || !backdrop || !toggle) return;
            function open() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            }
            function close() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }
            toggle.addEventListener('click', function() {
                sidebar.classList.contains('-translate-x-full') ? open() : close();
            });
            backdrop.addEventListener('click', close);
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) close();
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
