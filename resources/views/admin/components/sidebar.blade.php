{{-- iOS-style Sidebar Nav --}}
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
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #34C759;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </span>
            <span class="link-label sidebar-label">Lihat Website</span>
        </a>

        <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="sidebar-link sidebar-footer-label" title="Keluar">
                <span class="link-icon" style="background: rgba(255,59,48,0.1);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #FF3B30;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <span class="link-label sidebar-label" style="color: #FF3B30; font-weight:600;">Keluar</span>
            </button>
        </form>
    </div>
</aside>
