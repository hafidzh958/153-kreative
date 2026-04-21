@extends('admin.layouts.finance')
@section('title','Anggaran')
@section('page-title','Anggaran & Budgeting')

@section('content')

<div class="row-between mb-24">
  <div class="page-hd" style="margin:0">
    <h1>Anggaran</h1>
    <p>Monitor budget vs realisasi per event — deteksi over-budget secara otomatis</p>
  </div>
  <button onclick="openM('mCreate')" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Buat Anggaran
  </button>
</div>

<div class="info-box mb-24" style="font-size:11.5px">
  <strong>💡 Cara kerja Anggaran:</strong> Setiap anggaran dikaitkan dengan nama event. Sistem akan otomatis menghitung realisasi
  berdasarkan data di <strong>Pengeluaran</strong> yang memiliki nama event yang sama. Jika realisasi melebihi 100%, status akan
  otomatis berubah menjadi <strong>Over Budget</strong> 🔴.
</div>

@forelse($budgets as $b)
<div class="card mb-14" style="transition:all .2s">
  <div class="card-hd">
    <div style="min-width:0">
      <div class="card-title trunc" style="font-size:14px">{{ $b->event_name }}</div>
      @if($b->client_name)<div class="card-sub">👤 {{ $b->client_name }}</div>@endif
    </div>
    <div class="row" style="gap:8px;flex-shrink:0">
      @if($b->start_date || $b->end_date)
      <span class="smaller muted">📅 {{ $b->start_date?->format('d M Y') }} — {{ $b->end_date?->format('d M Y') }}</span>
      @endif
      <span class="s s-{{ $b->status }}">{{ ucwords(str_replace('_',' ',$b->status)) }}</span>
      <form action="{{ route('admin.finance.budgets.destroy',$b) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus anggaran ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
      </form>
    </div>
  </div>
  <div class="card-bd">
    <div class="row-between mb-10">
      <span class="muted" style="font-size:12px">Realisasi vs Anggaran</span>
      <span class="semibold" style="font-size:13px;color:{{ $b->actual > $b->total_budget ? '#f87171': 'var(--text)' }}">
        Rp {{ number_format($b->actual,0,',','.') }} / Rp {{ number_format($b->total_budget,0,',','.') }}
      </span>
    </div>
    <div class="progress-bar mb-8" style="height:8px">
      <div class="progress-fill" style="width:{{ min(100,$b->used_pct) }}%;background:{{ $b->used_pct > 100 ? '#ef4444' : ($b->used_pct > 80 ? '#f59e0b' : ($b->used_pct > 60 ? '#3b82f6' : '#10b981')) }}"></div>
    </div>
    <div class="row-between mb-16">
      <span class="smaller muted">{{ $b->used_pct }}% terpakai</span>
      @if($b->used_pct > 100)
      <span class="smaller" style="color:#f87171;font-weight:700">⚠ Over Budget!</span>
      @elseif($b->used_pct > 80)
      <span class="smaller" style="color:#fbbf24;font-weight:600">⚡ Mendekati batas</span>
      @else
      <span class="smaller" style="color:#34d399;font-weight:600">✓ Aman</span>
      @endif
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:8px">
      @foreach(['venue_budget'=>['Venue','#60a5fa'],'fb_budget'=>['F&B','#34d399'],'talent_budget'=>['Talent','#a78bfa'],'transport_budget'=>['Transport','#fbbf24'],'marketing_budget'=>['Marketing','#f87171'],'other_budget'=>['Lainnya','#94a3b8']] as $f=>[$l,$c])
      @if($b->$f > 0)
      <div style="background:var(--bg3);border:1px solid var(--border-l);border-radius:9px;padding:10px;text-align:center">
        <div style="font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:{{ $c }};margin-bottom:4px">{{ $l }}</div>
        <div style="font-size:13px;font-weight:700;color:var(--text)">{{ number_format($b->$f/1000000,1) }}Jt</div>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</div>
@empty
<div class="card">
  <div class="empty-state">
    <div class="empty-state-ico">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
    </div>
    <p>Belum ada anggaran dibuat</p>
    <button onclick="openM('mCreate')" class="btn btn-primary btn-sm">Buat Anggaran Pertama</button>
  </div>
</div>
@endforelse

@if($budgets->hasPages())<div class="mt-16">{{ $budgets->links() }}</div>@endif

<div id="mCreate" class="modal-wrap">
  <div class="modal">
    <div class="modal-hd">
      <div>
        <div class="modal-title">Buat Anggaran Event</div>
        <div class="modal-subtitle">Anggaran akan otomatis terhubung ke data pengeluaran</div>
      </div>
      <button class="modal-x" onclick="closeM('mCreate')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form action="{{ route('admin.finance.budgets.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="g2">
          <div class="fi-grp gc2"><label class="fl">Nama Event <span class="req">*</span></label><input type="text" name="event_name" required class="fi" placeholder="Workshop Annual 2025"></div>
          <div class="fi-grp"><label class="fl">Klien</label><input type="text" name="client_name" class="fi" placeholder="Nama klien"></div>
          <div class="fi-grp"><label class="fl">Total Anggaran (Rp) <span class="req">*</span></label><input type="number" name="total_budget" step="1000" min="0" required class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Budget Venue</label><input type="number" name="venue_budget" step="1000" min="0" class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Budget F&B</label><input type="number" name="fb_budget" step="1000" min="0" class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Budget Talent</label><input type="number" name="talent_budget" step="1000" min="0" class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Budget Transport</label><input type="number" name="transport_budget" step="1000" min="0" class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Budget Marketing</label><input type="number" name="marketing_budget" step="1000" min="0" class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Budget Lainnya</label><input type="number" name="other_budget" step="1000" min="0" class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Tanggal Mulai</label><input type="date" name="start_date" class="fi"></div>
          <div class="fi-grp"><label class="fl">Tanggal Selesai</label><input type="date" name="end_date" class="fi"></div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closeM('mCreate')" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Simpan Anggaran
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
