@extends('admin.layouts.finance')
@section('title', 'Pemasukan')
@section('page-title', 'Pemasukan')

@section('content')

  {{-- Page Header --}}
  <div class="row-between mb-24">
    <div class="page-hd" style="margin:0">
      <h1>Pemasukan</h1>
      <p>Catat semua penerimaan kas &amp; non-invoice dari berbagai sumber</p>
    </div>
    <div class="row" style="gap:8px">
      <a href="{{ route('admin.finance.incomes.export', request()->only(['category','month'])) }}"
         class="btn btn-outline" title="Export ke Excel (.csv)">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
        </svg>
        Export Excel
      </a>
      <button onclick="openM('mCreate')" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Catat Pemasukan
      </button>
    </div>
  </div>

  {{-- KPI --}}
  <div class="g3 mb-24">
    <div class="kpi">
      <div class="kpi-glow" style="background:#10b981"></div>
      <div class="kpi-ico" style="background:rgba(16,185,129,.12)">
        <svg fill="none" stroke="#34d399" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
      </div>
      <div class="kpi-lbl">Bulan Ini</div>
      <div class="kpi-val" style="color:#34d399">
        {{ $totalThisMonth >= 1e6 ? 'Rp ' . number_format($totalThisMonth / 1e6, 1) . ' Jt' : 'Rp ' . number_format($totalThisMonth, 0, ',', '.') }}
      </div>
      <div class="kpi-sub">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        {{ $countThisMonth }} transaksi
      </div>
    </div>
    <div class="kpi">
      <div class="kpi-glow" style="background:#3b82f6"></div>
      <div class="kpi-ico" style="background:rgba(59,130,246,.12)">
        <svg fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
      </div>
      <div class="kpi-lbl">Tahun {{ now()->format('Y') }}</div>
      <div class="kpi-val" style="color:#60a5fa">
        {{ $totalThisYear >= 1e6 ? 'Rp ' . number_format($totalThisYear / 1e6, 1) . ' Jt' : 'Rp ' . number_format($totalThisYear, 0, ',', '.') }}
      </div>
      <div class="kpi-sub">Akumulasi tahun ini</div>
    </div>
    <div class="kpi">
      <div class="kpi-glow" style="background:#f97316"></div>
      <div class="kpi-ico" style="background:rgba(249,115,22,.12)">
        <svg fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="kpi-lbl">Total Keseluruhan</div>
      <div class="kpi-val" style="color:#fb923c">
        {{ $totalAll >= 1e6 ? 'Rp ' . number_format($totalAll / 1e6, 1) . ' Jt' : 'Rp ' . number_format($totalAll, 0, ',', '.') }}
      </div>
      <div class="kpi-sub">Sejak awal pencatatan</div>
    </div>
  </div>

  {{-- Kategori bulan ini --}}
  @if($catTotals->count() > 0)
    @php
      $catLabels = ['event' => 'Pembayaran Event', 'dp' => 'Down Payment', 'retainer' => 'Retainer Fee', 'refund' => 'Refund', 'bonus' => 'Bonus', 'other' => 'Lainnya'];
      $catColors = ['event' => '#34d399', 'dp' => '#60a5fa', 'retainer' => '#a78bfa', 'refund' => '#fbbf24', 'bonus' => '#fb923c', 'other' => '#94a3b8'];
      $catBgs = ['event' => 'rgba(16,185,129,.1)', 'dp' => 'rgba(59,130,246,.1)', 'retainer' => 'rgba(139,92,246,.1)', 'refund' => 'rgba(245,158,11,.1)', 'bonus' => 'rgba(249,115,22,.1)', 'other' => 'rgba(148,163,184,.1)'];
    @endphp
    <div class="card mb-20">
      <div class="card-hd">
        <div class="card-title">Breakdown Kategori · {{ now()->format('F Y') }}</div>
      </div>
      <div class="card-bd">
        <div style="display:flex;flex-wrap:wrap;gap:10px">
          @foreach($catTotals as $cat => $amt)
            <div
              style="background:{{ $catBgs[$cat] ?? 'var(--bg3)' }};border:1px solid {{ $catColors[$cat] ?? 'var(--border)' }}33;border-radius:10px;padding:14px 18px;min-width:150px;flex:1">
              <div style="display:flex;align-items:center;gap:6px;margin-bottom:6px">
                <span
                  style="width:8px;height:8px;border-radius:50%;background:{{ $catColors[$cat] ?? '#94a3b8' }};display:inline-block;flex-shrink:0"></span>
                <span style="font-size:10.5px;color:var(--text-2);font-weight:600">{{ $catLabels[$cat] ?? $cat }}</span>
              </div>
              <div style="font-size:16px;font-weight:800;color:{{ $catColors[$cat] ?? '#94a3b8' }}">
                {{ $amt >= 1e6 ? 'Rp ' . number_format($amt / 1e6, 1) . ' Jt' : 'Rp ' . number_format($amt, 0, ',', '.') }}
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  {{-- Filter --}}
  <form method="GET" style="display:flex;gap:8px;margin-bottom:16px;align-items:center;flex-wrap:wrap">
    <div class="search-bar" style="width:260px">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi, sumber, event…">
    </div>
    <select name="category" class="fi" style="width:auto;padding:8px 12px">
      <option value="">Semua kategori</option>
      @foreach(['event' => 'Pembayaran Event', 'dp' => 'Down Payment', 'retainer' => 'Retainer Fee', 'refund' => 'Refund', 'bonus' => 'Bonus', 'other' => 'Lainnya'] as $v => $l)
        <option value="{{ $v }}" {{ request('category') === $v ? 'selected' : '' }}>{{ $l }}</option>
      @endforeach
    </select>
    <input type="month" name="month" value="{{ request('month') }}" class="fi" style="width:auto;padding:8px 12px">
    <button type="submit" class="btn btn-outline">Filter</button>
    @if(request()->hasAny(['search', 'category', 'month']))
      <a href="{{ route('admin.finance.incomes.index') }}" class="btn btn-ghost">× Reset</a>
    @endif
  </form>

  {{-- Table --}}
  <div class="card">
    <div style="overflow-x:auto">
      <table class="tbl">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Sumber / Klien</th>
            <th>Event</th>
            <th>Metode</th>
            <th>Referensi</th>
            <th class="tbl-right">Jumlah</th>
            <th class="tbl-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($incomes as $income)
            <tr>
              <td class="muted nowrap">{{ $income->date->format('d M Y') }}</td>
              <td>
                <div class="semibold" style="color:var(--text)">{{ $income->description }}</div>
                @if($income->notes)
                  <div class="smaller muted trunc" style="max-width:200px">{{ $income->notes }}</div>
                @endif
              </td>
              <td>
                @php $cc = $catColors[$income->category] ?? '#94a3b8';
                $cb = $catBgs[$income->category] ?? 'var(--bg3)'; @endphp
                <span
                  style="background:{{ $cb }};color:{{ $cc }};border:1px solid {{ $cc }}33;padding:3px 9px;border-radius:6px;font-size:10.5px;font-weight:700">
                  {{ $income->category_label }}
                </span>
              </td>
              <td class="muted">{{ $income->source ?? '—' }}</td>
              <td class="muted smaller">{{ $income->event_name ?? '—' }}</td>
              <td>
                <span
                  style="background:var(--bg3);border:1px solid var(--border);padding:3px 8px;border-radius:6px;font-size:10.5px;font-weight:600;color:var(--text-2)">
                  {{ $income->payment_method_label }}
                </span>
              </td>
              <td class="muted smaller mono">{{ $income->reference ?? '—' }}</td>
              <td class="tbl-right" style="font-weight:800;color:#34d399;font-size:13px">
                + Rp {{ number_format($income->amount, 0, ',', '.') }}
              </td>
              <td class="tbl-center">
                <form action="{{ route('admin.finance.incomes.destroy', $income) }}" method="POST" style="display:inline"
                  onsubmit="return confirm('Hapus data pemasukan ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9">
                <div class="empty-state">
                  <div class="empty-state-ico">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                  </div>
                  <p>Belum ada pemasukan tercatat</p>
                  <button onclick="openM('mCreate')" class="btn btn-primary btn-sm">Catat Pemasukan Pertama</button>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($incomes->hasPages())
      <div style="padding:12px 16px;border-top:1px solid var(--border-l)">{{ $incomes->links() }}</div>
    @endif
  </div>

  {{-- Create Modal --}}
  <div id="mCreate" class="modal-wrap">
    <div class="modal">
      <div class="modal-hd">
        <div>
          <div class="modal-title">Catat Pemasukan</div>
          <div class="modal-subtitle">Catat penerimaan kas dari event, DP, retainer, dll.</div>
        </div>
        <button class="modal-x" onclick="closeM('mCreate')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg></button>
      </div>
      <form action="{{ route('admin.finance.incomes.store') }}" method="POST">
        @csrf
        <div class="modal-bd">
          <div class="g2">
            <div class="fi-grp gc2">
              <label class="fl">Deskripsi <span class="req">*</span></label>
              <input type="text" name="description" required class="fi"
                placeholder="Pembayaran event annual gathering PT. XYZ">
            </div>
            <div class="fi-grp">
              <label class="fl">Jumlah (Rp) <span class="req">*</span></label>
              <input type="number" name="amount" step="1000" min="0" required class="fi" placeholder="0">
            </div>
            <div class="fi-grp">
              <label class="fl">Tanggal Terima <span class="req">*</span></label>
              <input type="date" name="date" value="{{ now()->toDateString() }}" required class="fi">
            </div>
            <div class="fi-grp">
              <label class="fl">Kategori <span class="req">*</span></label>
              <select name="category" required class="fi">
                <option value="event">Pembayaran Event</option>
                <option value="dp">Down Payment (DP)</option>
                <option value="retainer">Retainer Fee</option>
                <option value="refund">Refund / Pengembalian</option>
                <option value="bonus">Bonus / Insentif</option>
                <option value="other">Lainnya</option>
              </select>
            </div>
            <div class="fi-grp">
              <label class="fl">Metode Pembayaran <span class="req">*</span></label>
              <select name="payment_method" required class="fi">
                <option value="transfer">Transfer Bank</option>
                <option value="cash">Tunai (Cash)</option>
                <option value="qris">QRIS</option>
                <option value="check">Cek / Giro</option>
              </select>
            </div>
            <div class="fi-grp">
              <label class="fl">Sumber / Klien</label>
              <input type="text" name="source" class="fi" placeholder="Nama klien / sumber dana">
            </div>
            <div class="fi-grp">
              <label class="fl">Nama Event</label>
              <input type="text" name="event_name" class="fi" placeholder="Annual Gathering 2025">
            </div>
            <div class="fi-grp">
              <label class="fl">No. Referensi / Kwitansi</label>
              <input type="text" name="reference" class="fi" placeholder="KWT-001 / TRF-20250401">
            </div>
            <div class="fi-grp gc2">
              <label class="fl">Catatan</label>
              <textarea name="notes" rows="2" class="fi" style="resize:none" placeholder="Catatan tambahan…"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-ft">
          <button type="button" onclick="closeM('mCreate')" class="btn btn-outline">Batal</button>
          <button type="submit" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Simpan Pemasukan
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function openM(id) { document.getElementById(id).classList.add('open'); }
    function closeM(id) { document.getElementById(id).classList.remove('open'); }
    document.querySelectorAll('.modal-wrap').forEach(w => w.addEventListener('click', e => { if (e.target === w) w.classList.remove('open'); }));
    @if($errors->any())
      window.addEventListener('DOMContentLoaded', () => openM('mCreate'));
    @endif
  </script>
@endpush