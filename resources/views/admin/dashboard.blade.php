@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ── iOS Dashboard Styles ── */
:root {
  --ios-blue:   #007AFF;
  --ios-green:  #34C759;
  --ios-orange: #FF9500;
  --ios-indigo: #5856D6;
  --ios-red:    #FF3B30;
  --ios-teal:   #5AC8FA;
  --bg:         #F2F2F7;
  --surface:    #FFFFFF;
  --fill-3:     rgba(118,118,128,.12);
  --fill-4:     rgba(116,116,128,.08);
  --label:      #000000;
  --label-2:    rgba(60,60,67,.6);
  --label-3:    rgba(60,60,67,.3);
  --sep-opaque: #C6C6C8;
  --sh:         0 4px 16px rgba(0,0,0,.07),0 2px 6px rgba(0,0,0,.04);
  --sh-lg:      0 12px 40px rgba(0,0,0,.10),0 4px 12px rgba(0,0,0,.06);
  --r-sm:  10px;
  --r-md:  14px;
  --r-lg:  18px;
  --r-xl:  22px;
  --spring: cubic-bezier(.34,1.56,.64,1);
  --ease:   cubic-bezier(.25,.46,.45,.94);
}

/* Stat Cards */
.stat-cards {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}
@media(max-width:768px){ .stat-cards{grid-template-columns:1fr} }
@media(max-width:1024px) and (min-width:769px){ .stat-cards{grid-template-columns:repeat(3,1fr)} }

.stat-card {
  background: var(--surface);
  border-radius: var(--r-lg);
  padding: 20px;
  box-shadow: var(--sh);
  display: flex;
  align-items: flex-start;
  gap: 14px;
  transition: all .25s var(--ease);
  cursor: default;
}
.stat-card:hover { box-shadow: var(--sh-lg); transform: translateY(-3px); }

.stat-icon {
  width: 46px; height: 46px;
  border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.stat-icon svg { width: 22px; height: 22px; }

.stat-body { flex: 1; min-width: 0; }
.stat-label {
  font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .07em;
  color: var(--label-3); margin-bottom: 4px;
}
.stat-value {
  font-size: 28px; font-weight: 800;
  color: var(--label); letter-spacing: -1px; line-height: 1;
}
.stat-desc { font-size: 12px; color: var(--label-3); margin-top: 5px; }

/* Two-column grid */
.dash-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 20px;
}
@media(max-width:1024px){ .dash-grid{grid-template-columns:1fr} }

/* iOS Card */
.ios-card {
  background: var(--surface);
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: var(--sh);
  margin-bottom: 20px;
  transition: all .25s var(--ease);
}
.ios-card:hover { box-shadow: var(--sh-lg); }
.ios-card:last-child { margin-bottom: 0; }

.ios-card-hd {
  padding: 16px 20px;
  border-bottom: .5px solid var(--sep-opaque);
  display: flex; align-items: center; justify-content: space-between;
}
.ios-card-title {
  font-size: 15px; font-weight: 700;
  color: var(--label); letter-spacing: -.3px;
}

/* Welcome banner */
.welcome-banner {
  background: var(--ios-blue);
  border-radius: var(--r-lg);
  padding: 24px;
  margin-bottom: 20px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 28px rgba(0,122,255,.3);
}
.welcome-banner::before {
  content: '';
  position: absolute;
  right: -40px; top: -40px;
  width: 200px; height: 200px;
  border-radius: 50%;
  background: rgba(255,255,255,.08);
}
.welcome-banner::after {
  content: '';
  position: absolute;
  right: 40px; bottom: -60px;
  width: 140px; height: 140px;
  border-radius: 50%;
  background: rgba(255,255,255,.05);
}
.welcome-banner h3 {
  font-size: 17px; font-weight: 800;
  color: #fff; letter-spacing: -.4px;
  margin-bottom: 6px; position: relative; z-index: 1;
}
.welcome-banner p {
  font-size: 13.5px; color: rgba(255,255,255,.8);
  line-height: 1.6; position: relative; z-index: 1;
}
.welcome-banner a { color: rgba(255,255,255,.95); font-weight: 700; text-decoration: none; }
.welcome-banner a:hover { text-decoration: underline; }

/* Activity list */
.activity-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 13px 20px;
  border-bottom: .5px solid rgba(60,60,67,.06);
  text-decoration: none;
  transition: background .15s;
}
.activity-item:last-child { border-bottom: none; }
.activity-item:hover { background: var(--fill-4); }

.activity-icon {
  width: 36px; height: 36px;
  border-radius: var(--r-sm);
  background: rgba(0,122,255,.1);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.activity-icon svg { width: 16px; height: 16px; color: var(--ios-blue); }

.activity-info { flex: 1; min-width: 0; }
.activity-title {
  font-size: 13.5px; font-weight: 600;
  color: var(--label); white-space: nowrap;
  overflow: hidden; text-overflow: ellipsis;
}
.activity-meta { font-size: 12px; color: var(--label-3); margin-top: 2px; }

.activity-chevron { color: var(--label-3); flex-shrink: 0; }
.activity-chevron svg { width: 14px; height: 14px; }

/* Quick Actions */
.quick-action {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 20px;
  border-bottom: .5px solid rgba(60,60,67,.06);
  text-decoration: none;
  transition: background .15s;
}
.quick-action:last-child { border-bottom: none; }
.quick-action:hover { background: var(--fill-4); }
.quick-action-left {
  display: flex; align-items: center; gap: 12px;
}
.quick-action-icon {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.quick-action-icon svg { width: 15px; height: 15px; }
.quick-action-label {
  font-size: 14px; font-weight: 600; color: var(--label);
}
.quick-action-chevron svg { width: 14px; height: 14px; color: var(--label-3); }

/* Tips list */
.tip-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 10px 20px;
  border-bottom: .5px solid rgba(60,60,67,.06);
}
.tip-item:last-child { border-bottom: none; }
.tip-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: var(--ios-blue);
  flex-shrink: 0; margin-top: 5px;
}
.tip-text { font-size: 13.5px; color: var(--label-2); line-height: 1.5; }
</style>
@endpush

@section('content')

{{-- Stat Cards --}}
<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(0,122,255,.1);">
            <svg fill="none" stroke="#007AFF" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 4h16M5 4l1 9a3 3 0 003 3h6a3 3 0 003-3l1-9"/>
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-label">Services</div>
            <div class="stat-value">{{ $servicesCount ?? 0 }}</div>
            <div class="stat-desc">Layanan di halaman utama</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(255,149,0,.1);">
            <svg fill="none" stroke="#FF9500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-label">Portfolio</div>
            <div class="stat-value">{{ $portfolioCount ?? 0 }}</div>
            <div class="stat-desc">Hasil karya yang ditampilkan</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(52,199,89,.1);">
            <svg fill="none" stroke="#34C759" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-label">Testimonials</div>
            <div class="stat-value">{{ $testimonialsCount ?? 0 }}</div>
            <div class="stat-desc">Testimoni klien</div>
        </div>
    </div>
</div>

{{-- Two-column grid --}}
<div class="dash-grid">

    {{-- Left column --}}
    <div>
        {{-- Welcome Banner --}}
        <div class="welcome-banner">
            <h3>Selamat datang di 153 Kreatif Admin 👋</h3>
            <p>
                Kelola konten website dari sini:
                <a href="{{ route('admin.services.index') }}">Services</a>,
                <a href="{{ route('admin.portfolio.index') }}">Portfolio</a>,
                dan <a href="{{ route('admin.contact.index') }}">Contact</a>.
            </p>
        </div>

        {{-- Recent Activity --}}
        <div class="ios-card">
            <div class="ios-card-hd">
                <span class="ios-card-title">Aktivitas Terbaru</span>
            </div>
            @if($recentActivity->isNotEmpty())
                @foreach($recentActivity as $item)
                    <a href="{{ $item->url }}" class="activity-item">
                        <div class="activity-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="activity-info">
                            <div class="activity-title">{{ $item->title }}</div>
                            <div class="activity-meta">{{ ucfirst($item->type) }} · {{ $item->created_at?->diffForHumans() }}</div>
                        </div>
                        <div class="activity-chevron">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            @else
                <div style="padding: 48px 24px; text-align: center;">
                    <p style="font-size:14px; color:var(--label-3); margin-bottom:6px;">Belum ada aktivitas</p>
                    <p style="font-size:12.5px; color:var(--label-3);">Tambah service atau portfolio untuk memulai</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Right column --}}
    <div>
        {{-- Quick Actions --}}
        <div class="ios-card">
            <div class="ios-card-hd">
                <span class="ios-card-title">Quick Actions</span>
            </div>
            <a href="{{ route('admin.services.index') }}" class="quick-action">
                <div class="quick-action-left">
                    <div class="quick-action-icon" style="background:rgba(0,122,255,.1);">
                        <svg fill="none" stroke="#007AFF" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="quick-action-label">Tambah Service</span>
                </div>
                <div class="quick-action-chevron">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            <a href="{{ route('admin.portfolio.index') }}" class="quick-action">
                <div class="quick-action-left">
                    <div class="quick-action-icon" style="background:rgba(255,149,0,.1);">
                        <svg fill="none" stroke="#FF9500" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                        </svg>
                    </div>
                    <span class="quick-action-label">Kelola Portfolio</span>
                </div>
                <div class="quick-action-chevron">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            <a href="{{ route('admin.finance.index') }}" class="quick-action">
                <div class="quick-action-left">
                    <div class="quick-action-icon" style="background:rgba(52,199,89,.1);">
                        <svg fill="none" stroke="#34C759" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="quick-action-label">Finance</span>
                </div>
                <div class="quick-action-chevron">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>

        {{-- Quick Tips --}}
        <div class="ios-card">
            <div class="ios-card-hd">
                <span class="ios-card-title">Quick Tips</span>
            </div>
            <div class="tip-item">
                <div class="tip-dot"></div>
                <div class="tip-text">Gambar portfolio sebaiknya berukuran besar dan proporsional</div>
            </div>
            <div class="tip-item">
                <div class="tip-dot"></div>
                <div class="tip-text">Deskripsi singkat dan jelas akan lebih menarik pengunjung</div>
            </div>
            <div class="tip-item">
                <div class="tip-dot"></div>
                <div class="tip-text">Data yang disimpan langsung tampil di halaman depan</div>
            </div>
        </div>
    </div>

</div>
@endsection
