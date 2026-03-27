<aside id="admin-sidebar" class="fixed md:relative inset-y-0 left-0 z-50 md:z-auto w-64 md:w-60 -translate-x-full md:translate-x-0 flex flex-col border-r border-gray-200 bg-gray-50 md:bg-gray-50/80 min-h-screen py-5 transition-transform duration-200 ease-out md:transition-none">
    {{-- Logo --}}
    <div class="px-4 mb-6">
        <a href="{{ route('admin.home.index') }}" class="flex items-center gap-3 px-2 py-1.5 -mx-2 rounded-lg hover:bg-white/60 transition-colors">
            <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0 bg-white shadow-sm">
                <img src="{{ asset('images/logo-153.png') }}" alt="153 Kreatif" class="h-8 w-auto object-contain">
            </div>
            <div class="leading-tight min-w-0">
                <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Kreatif</p>
                <p class="text-sm font-semibold text-gray-900 truncate">Admin Panel</p>
            </div>
        </a>
    </div>

    {{-- Nav - 8px spacing (gap-2 = 8px) --}}
    <nav class="flex-1 px-3 space-y-0.5">
        @php
            $linkBase = 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150';
            $activeClasses = 'bg-[#f97316] text-white shadow-sm';
            $inactiveClasses = 'text-gray-600 hover:bg-white hover:text-gray-900';
        @endphp

        <a href="{{ route('admin.home.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.home.index') ? $activeClasses : $inactiveClasses }}">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.home.index') ? '2' : '1.5' }}" d="M3 12l2-2m0 0l7-7 7 7M5 10v10h5m4 0h5V10m-9 10v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
                </svg>
            </span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.services.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.services.*') ? $activeClasses : $inactiveClasses }}">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.services.*') ? '2' : '1.5' }}" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 4h16M5 4l1 9a3 3 0 003 3h6a3 3 0 003-3l1-9"/>
                </svg>
            </span>
            <span>Services</span>
        </a>

        <a href="{{ route('admin.portfolio.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.portfolio.*') ? $activeClasses : $inactiveClasses }}">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.portfolio.*') ? '2' : '1.5' }}" d="M4 5h16M4 19h16M5 5l1 11a2 2 0 002 2h8a2 2 0 002-2l1-11M9 9h6l-3 4-1.5-2L9 13"/>
                </svg>
            </span>
            <span>Portfolio</span>
        </a>

        <a href="{{ route('admin.clients.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.clients.*') ? $activeClasses : $inactiveClasses }}">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.clients.*') ? '2' : '1.5' }}" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </span>
            <span>Mitra (Clients)</span>
        </a>

        <a href="{{ route('admin.testimonials.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.testimonials.*') ? $activeClasses : $inactiveClasses }}">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.testimonials.*') ? '2' : '1.5' }}" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </span>
            <span>Testimonial</span>
        </a>

        <a href="{{ route('admin.contact.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.contact.*') ? $activeClasses : $inactiveClasses }}">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.contact.*') ? '2' : '1.5' }}" d="M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72A7.962 7.962 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 11h.01M12 11h.01M16 11h.01"/>
                </svg>
            </span>
            <span>Contact</span>
        </a>
    </nav>

    {{-- Footer link --}}
    <div class="px-3 pt-4 mt-4 border-t border-gray-200">
        <a href="{{ route('home') }}" target="_blank"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-white hover:text-gray-900 transition-colors group">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0 text-gray-400 group-hover:text-[#f97316]">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </span>
            <div class="min-w-0 flex-1">
                <span class="font-medium block">Lihat Website</span>
                <span class="text-xs text-gray-400">Buka di tab baru</span>
            </div>
        </a>
    </div>
</aside>
