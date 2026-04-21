{{-- iOS-style Admin Topbar — included by layouts/app.blade.php --}}
<header id="admin-topbar">
    {{-- Sidebar Toggle --}}
    <button type="button" id="sidebar-toggle" aria-label="Toggle sidebar">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
    </button>

    {{-- Title --}}
    <span class="topbar-title">Admin Kreatif 153</span>

    <div class="topbar-spacer"></div>

    {{-- Preview website link --}}
    <a href="{{ route('home') }}" target="_blank" class="topbar-action hidden sm:inline-flex">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        Lihat Website
    </a>
</header>
