<aside id="admin-sidebar" class="fixed left-0 z-40 flex flex-col border-r border-gray-200 bg-gray-50 overflow-hidden">
    {{-- Nav Links --}}
    <nav class="flex-1 px-2 py-4 space-y-0.5 overflow-y-auto">
        @php
            $linkBase = 'sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150';
            $activeClasses = 'bg-[#f97316] text-white shadow-sm';
            $inactiveClasses = 'text-gray-600 hover:bg-white hover:text-gray-900';
        @endphp



        <a href="{{ route('admin.home.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.home.*') ? $activeClasses : $inactiveClasses }}"
           title="Home">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.home.*') ? '2' : '1.5' }}" d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.home.*') ? '2' : '1.5' }}" d="M9 21V12h6v9"/>
                </svg>
            </span>
            <span class="sidebar-label">Home</span>
        </a>

        <a href="{{ route('admin.about.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.about.*') ? $activeClasses : $inactiveClasses }}"
           title="About">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.about.*') ? '2' : '1.5' }}" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <span class="sidebar-label">About</span>
        </a>

        <a href="{{ route('admin.services.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.services.*') ? $activeClasses : $inactiveClasses }}"
           title="Services">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.services.*') ? '2' : '1.5' }}" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 4h16M5 4l1 9a3 3 0 003 3h6a3 3 0 003-3l1-9"/>
                </svg>
            </span>
            <span class="sidebar-label">Services</span>
        </a>

        <a href="{{ route('admin.portfolio.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.portfolio.*') ? $activeClasses : $inactiveClasses }}"
           title="Portfolio">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.portfolio.*') ? '2' : '1.5' }}" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </span>
            <span class="sidebar-label">Portfolio</span>
        </a>

        <a href="{{ route('admin.contact.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.contact.*') ? $activeClasses : $inactiveClasses }}"
           title="Contact">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('admin.contact.*') ? '2' : '1.5' }}" d="M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72A7.962 7.962 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 11h.01M12 11h.01M16 11h.01"/>
                </svg>
            </span>
            <span class="sidebar-label">Contact</span>
        </a>
    </nav>

    {{-- Footer --}}
    <div class="px-2 py-3 border-t border-gray-200 flex-shrink-0 flex flex-col gap-1">
        <a href="{{ route('home') }}" target="_blank" title="Lihat Website"
           class="sidebar-link sidebar-footer-label flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-white hover:text-[#f97316] transition-colors group">
            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </span>
            <span class="sidebar-label">Lihat Website</span>
        </a>

        <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" title="Keluar"
                    class="w-full sidebar-link sidebar-footer-label flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors group">
                <span class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <span class="sidebar-label">Keluar</span>
            </button>
        </form>
    </div>
</aside>
