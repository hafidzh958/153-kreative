@extends('admin.layouts.finance')
@section('title','Pengeluaran')
@section('page-title','Biaya & Pengeluaran')

@section('content')

<div class="row-between mb-24">
  <div class="page-hd" style="margin:0">
    <h1>Biaya &amp; Pengeluaran</h1>
    <p>Catat dan kategorikan semua pengeluaran operasional</p>
  </div>
  <div class="row" style="gap:8px">
    <a href="{{ route('admin.finance.expenses.export', request()->only(['category','month'])) }}"
       class="btn btn-outline" title="Export ke Excel (.csv)">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
      </svg>
      Export Excel
    </a>
    <button onclick="openM('mCreate')" class="btn btn-primary">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Catat Pengeluaran
    </button>
  </div>
</div>

{{-- KPI --}}
<div class="g3 mb-24">
  <div class="kpi">
    <div class="kpi-glow" style="background:#ef4444"></div>
    <div class="kpi-ico" style="background:rgba(239,68,68,.12)">
      <svg fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>
    <div class="kpi-lbl">Bulan Ini</div>
    <div class="kpi-val" style="color:#f87171">
      {{ $totalThisMonth >= 1e6 ? 'Rp '.number_format($totalThisMonth/1e6,1).' Jt' : 'Rp '.number_format($totalThisMonth,0,',','.') }}
    </div>
    <div class="kpi-sub">Total pengeluaran bulan ini</div>
  </div>
  <div class="kpi">
    <div class="kpi-glow" style="background:#f59e0b"></div>
    <div class="kpi-ico" style="background:rgba(245,158,11,.12)">
      <svg fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
    </div>
    <div class="kpi-lbl">Tahun {{ now()->format('Y') }}</div>
    <div class="kpi-val" style="color:#fbbf24">
      {{ $totalThisYear >= 1e6 ? 'Rp '.number_format($totalThisYear/1e6,1).' Jt' : 'Rp '.number_format($totalThisYear,0,',','.') }}
    </div>
    <div class="kpi-sub">Total pengeluaran tahun ini</div>
  </div>
  <div class="kpi">
    <div class="kpi-glow" style="background:#8b5cf6"></div>
    <div class="kpi-ico" style="background:rgba(139,92,246,.12)">
      <svg fill="none" stroke="#a78bfa" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <div class="kpi-lbl">Total Keseluruhan</div>
    <div class="kpi-val" style="color:#a78bfa">
      @php $totalAll = \App\Models\Finance\FinExpense::sum('amount'); @endphp
      {{ $totalAll >= 1e6 ? 'Rp '.number_format($totalAll/1e6,1).' Jt' : 'Rp '.number_format($totalAll,0,',','.') }}
    </div>
    <div class="kpi-sub">Sejak awal pencatatan</div>
  </div>
</div>

{{-- Category Breakdown --}}
@if($catTotals && $catTotals->count())
@php
$catMap = ['venue'=>['Venue','#60a5fa','rgba(59,130,246,.1)'],'fb'=>['F&B','#34d399','rgba(16,185,129,.1)'],'transport'=>['Transport','#fbbf24','rgba(245,158,11,.1)'],'talent'=>['Talent','#a78bfa','rgba(139,92,246,.1)'],'marketing'=>['Marketing','#f87171','rgba(239,68,68,.1)'],'salary'=>['Gaji/HR','#fb923c','rgba(249,115,22,.1)'],'other'=>['Lainnya','#94a3b8','rgba(148,163,184,.1)']];
@endphp
<div class="card mb-20">
  <div class="card-hd">
    <div class="card-title">Breakdown per Kategori · {{ now()->format('F Y') }}</div>
  </div>
  <div class="card-bd">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px">
      @foreach($catTotals as $cat=>$amt)
      @php [$lbl,$clr,$bg] = $catMap[$cat] ?? [$cat,'#94a3b8','var(--bg3)']; @endphp
      <div style="background:{{ $bg }};border:1px solid {{ $clr }}25;border-radius:10px;padding:14px;text-align:center">
        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:{{ $clr }};margin-bottom:6px">{{ $lbl }}</div>
        <div style="font-size:15px;font-weight:800;color:{{ $clr }}">{{ $amt >= 1e6 ? number_format($amt/1e6,1).'Jt' : number_format($amt,0,',','.') }}</div>
        <div style="font-size:10px;color:var(--text-3);margin-top:2px">Rp</div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- Filter Bar --}}
<form method="GET" style="display:flex;gap:8px;margin-bottom:16px;align-items:center;flex-wrap:wrap">
  <div class="search-bar" style="width:260px">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi, event, vendor…">
  </div>
  <select name="category" class="fi" style="width:auto;padding:8px 12px">
    <option value="">Semua kategori</option>
    @foreach(['venue'=>'Venue','fb'=>'F&B','transport'=>'Transport','talent'=>'Talent','marketing'=>'Marketing','salary'=>'Gaji/HR','other'=>'Lainnya'] as $v=>$l)
      <option value="{{ $v }}" {{ request('category') === $v ? 'selected' : '' }}>{{ $l }}</option>
    @endforeach
  </select>
  <input type="month" name="month" value="{{ request('month') }}" class="fi" style="width:auto;padding:8px 12px">
  <button type="submit" class="btn btn-outline">Filter</button>
  @if(request()->hasAny(['search','category','month']))
    <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-ghost">× Reset</a>
  @endif
</form>

<div class="card">
  <div style="overflow-x:auto">
    <table class="tbl">
      <thead>
        <tr>
          <th>Tanggal</th><th>Deskripsi</th><th>Kategori</th><th>Event</th>
          <th class="tbl-right">Jumlah</th><th class="tbl-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($expenses as $e)
      <tr>
        <td class="muted nowrap">{{ $e->date?->format('d M Y') }}</td>
        <td>
          <div class="semibold" style="color:var(--text)">{{ $e->description }}</div>
          @if($e->employee_name)<div class="smaller muted">{{ $e->employee_name }}</div>@endif
        </td>
        <td>
          @php [$lbl,$clr,$bg] = $catMap[$e->category] ?? [$e->category,'#94a3b8','var(--bg3)']; @endphp
          <span style="background:{{ $bg }};color:{{ $clr }};border:1px solid {{ $clr }}25;padding:3px 9px;border-radius:6px;font-size:10.5px;font-weight:700">{{ $lbl }}</span>
        </td>
        <td class="muted smaller">{{ $e->event_name ?? '—' }}</td>
        <td class="tbl-right semibold" style="color:#f87171;font-size:13px">
          − Rp {{ number_format($e->amount,0,',','.') }}
        </td>
        <td class="tbl-center">
          <form action="{{ route('admin.finance.expenses.destroy',$e) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus pengeluaran ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6">
        <div class="empty-state">
          <div class="empty-state-ico">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
          </div>
          <p>Belum ada pengeluaran tercatat</p>
          <button onclick="openM('mCreate')" class="btn btn-primary btn-sm">Catat Pengeluaran</button>
        </div>
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($expenses->hasPages())<div style="padding:12px 16px;border-top:1px solid var(--border-l)">{{ $expenses->links() }}</div>@endif
</div>

<div id="mCreate" class="modal-wrap">
  <div class="modal">
    <div class="modal-hd">
      <div>
        <div class="modal-title">Catat Pengeluaran</div>
        <div class="modal-subtitle">Operasional, vendor, event, dll.</div>
      </div>
      <button class="modal-x" onclick="closeM('mCreate')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form action="{{ route('admin.finance.expenses.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="g2">
          <div class="fi-grp gc2"><label class="fl">Deskripsi <span class="req">*</span></label><input type="text" name="description" required class="fi" placeholder="Sewa Gedung, Catering, dll."></div>
          <div class="fi-grp"><label class="fl">Jumlah (Rp) <span class="req">*</span></label><input type="number" name="amount" step="1000" min="0" required class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Tanggal <span class="req">*</span></label><input type="date" name="date" value="{{ now()->toDateString() }}" required class="fi"></div>
          <div class="fi-grp">
            <label class="fl">Kategori <span class="req">*</span></label>
            <select name="category" required class="fi">
              @foreach(['venue'=>'Venue','fb'=>'F&B','transport'=>'Transport','talent'=>'Talent','marketing'=>'Marketing','salary'=>'Gaji / HR','other'=>'Lainnya'] as $v=>$l)
              <option value="{{ $v }}">{{ $l }}</option>
              @endforeach
            </select>
          </div>
          <div class="fi-grp"><label class="fl">Nama Event</label><input type="text" name="event_name" class="fi" placeholder="Nama event (opsional)"></div>
          <div class="fi-grp"><label class="fl">Staff / Vendor</label><input type="text" name="employee_name" class="fi" placeholder="Nama penerima dana"></div>
          <div class="fi-grp gc2"><label class="fl">Catatan</label><textarea name="notes" rows="2" class="fi" style="resize:none" placeholder="Catatan tambahan..."></textarea></div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closeM('mCreate')" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openM(id){ document.getElementById(id).classList.add('open'); }
function closeM(id){ document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-wrap').forEach(w => w.addEventListener('click', e => { if(e.target===w) w.classList.remove('open'); }));
</script>
@endpush
