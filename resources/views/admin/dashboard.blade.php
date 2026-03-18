@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- 1. Compact Statistic Cards - 8px grid (gap-3 = 12px, p-4 = 16px) --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-4 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Services</p>
                <p class="text-2xl font-semibold text-gray-900 tabular-nums">{{ $servicesCount ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Layanan di halaman utama</p>
            </div>
            <div class="flex-shrink-0 ml-3 w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 4h16M5 4l1 9a3 3 0 003 3h6a3 3 0 003-3l1-9"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-4 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Portfolio</p>
                <p class="text-2xl font-semibold text-gray-900 tabular-nums">{{ $portfolioCount ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Hasil karya yang ditampilkan</p>
            </div>
            <div class="flex-shrink-0 ml-3 w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5h16M4 19h16M5 5l1 11a2 2 0 002 2h8a2 2 0 002-2l1-11M9 9h6l-3 4-1.5-2L9 13"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-4 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Testimonials</p>
                <p class="text-2xl font-semibold text-gray-900 tabular-nums">{{ $testimonialsCount ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Testimoni klien</p>
            </div>
            <div class="flex-shrink-0 ml-3 w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h10M7 11h6M7 15h3M5 5a2 2 0 00-2 2v10l3-3h11a2 2 0 002-2V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- 2. Two-column main content --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left column: Welcome + Activity --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Welcome card --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <h3 class="text-base font-semibold text-gray-900 mb-2">Selamat datang di 153 Kreatif Admin</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Kelola konten website company profile dari sidebar:
                <a href="{{ route('admin.services.index') }}" class="text-[#f97316] hover:underline font-medium">Services</a>,
                <a href="{{ route('admin.portfolio.index') }}" class="text-[#f97316] hover:underline font-medium">Portfolio</a>,
                dan <a href="{{ route('admin.contact.index') }}" class="text-[#f97316] hover:underline font-medium">Contact</a>.
            </p>
        </div>

        {{-- Recent activity --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h4 class="text-sm font-semibold text-gray-900">Aktivitas terbaru</h4>
            </div>
            <div class="divide-y divide-gray-50">
                @if($recentActivity->isNotEmpty())
                    @foreach($recentActivity as $item)
                        <a href="{{ $item->url }}" class="flex items-center gap-4 px-5 py-3 hover:bg-gray-50 transition-colors group">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5h16M4 19h16M5 5l1 11a2 2 0 002 2h8a2 2 0 002-2l1-11"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-[#f97316]">{{ $item->title }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($item->type) }} · {{ $item->created_at?->diffForHumans() }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                @else
                    <div class="px-5 py-8 text-center">
                        <p class="text-sm text-gray-500">Belum ada aktivitas.</p>
                        <p class="text-xs text-gray-400 mt-1">Tambah service atau portfolio untuk memulai.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right column: Quick tips + Quick actions --}}
    <div class="space-y-6">
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <h4 class="text-sm font-semibold text-gray-900 mb-3">Quick Tips</h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex gap-2">
                    <span class="text-[#f97316]">•</span>
                    <span>Gambar portfolio berukuran besar & rapi</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-[#f97316]">•</span>
                    <span>Deskripsi singkat dan jelas untuk service</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-[#f97316]">•</span>
                    <span>Data langsung tampil di halaman depan</span>
                </li>
            </ul>
        </div>

        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <h4 class="text-sm font-semibold text-gray-900 mb-3">Quick Actions</h4>
            <div class="space-y-2">
                <a href="{{ route('admin.services.index') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-lg border border-gray-100 hover:border-[#f97316]/30 hover:bg-orange-50/50 transition-colors group">
                    <span class="text-sm font-medium text-gray-700 group-hover:text-[#f97316]">Tambah Service</span>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>
                <a href="{{ route('admin.portfolio.index') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-lg border border-gray-100 hover:border-[#f97316]/30 hover:bg-orange-50/50 transition-colors group">
                    <span class="text-sm font-medium text-gray-700 group-hover:text-[#f97316]">Kelola Portfolio</span>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
