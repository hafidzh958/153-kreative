@extends('admin.layouts.finance')
@section('title', 'Dashboard Keuangan')
@section('page-title', 'Dashboard Keuangan')

@section('content')

  {{-- Header --}}
  <div class="row-between mb-24">
    <div class="page-hd" style="margin:0">
      <div style="font-size:24px;font-weight:800;color:var(--text);letter-spacing:-.5px">Hallo Tim 153 👋</div>
      <form method="GET" class="row mt-8" style="gap:8px">
        <select name="period" class="fi" style="width:auto;padding:4px 30px 4px 12px;font-size:12px;min-height:30px"
          onchange="this.form.submit()">
          <option value="day" {{ request('period') == 'day' ? 'selected' : '' }}>Hari Ini</option>
          <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
          <option value="month" {{ request('period') == 'month' || !request('period') ? 'selected' : '' }}>Bulan Ini
          </option>
          <option value="6months" {{ request('period') == '6months' ? 'selected' : '' }}>6 Bulan Terakhir</option>
          <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
          <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
        </select>
        <div class="muted small">· Diperbarui {{ now()->format('d M Y, H:i') }}</div>
      </form>
    </div>
    <a href="{{ route('admin.finance.invoices.create') }}" class="btn btn-primary">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Buat Invoice
    </a>
  </div>

  {{-- Overdue Alert --}}
  @if($overdueInvoices->count() > 0)
    <div class="alert alert-warn mb-24">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
      <span><strong>{{ $overdueInvoices->count() }} invoice overdue</strong> — Rp
        {{ number_format($overdueInvoices->sum(fn($i) => $i->total - $i->paid_amount), 0, ',', '.') }}</span>
      <a href="{{ route('admin.finance.invoices.index', ['status' => 'overdue']) }}"
        style="margin-left:auto;font-weight:700;color:var(--brand);text-decoration:none;white-space:nowrap">Lihat →</a>
    </div>
  @endif

  {{-- KPI Cards --}}
  <div class="g4 mb-24">
    <div class="kpi">
      <div class="kpi-glow" style="background:var(--brand)"></div>
      <div class="kpi-ico" style="background:var(--brand-l)">
        <svg fill="none" stroke="var(--brand)" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="kpi-lbl">Revenue</div>
      <div class="kpi-val" style="color:var(--brand)">
        {{ $totalRevenue >= 1e6 ? 'Rp ' . number_format($totalRevenue / 1e6, 1) . 'Jt' : 'Rp ' . number_format($totalRevenue, 0, ',', '.') }}
      </div>
      <div class="kpi-sub">{{ now()->format('M Y') }}</div>
    </div>
    <div class="kpi">
      <div class="kpi-glow" style="background:#ef4444"></div>
      <div class="kpi-ico" style="background:var(--red-l)">
        <svg fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
      </div>
      <div class="kpi-lbl">Pengeluaran</div>
      <div class="kpi-val" style="color:#f87171">
        {{ $totalExpenses >= 1e6 ? 'Rp ' . number_format($totalExpenses / 1e6, 1) . 'Jt' : 'Rp ' . number_format($totalExpenses, 0, ',', '.') }}
      </div>
      <div class="kpi-sub">{{ now()->format('M Y') }}</div>
    </div>
    <div class="kpi">
      <div class="kpi-glow" style="background:{{ $netProfit >= 0 ? '#10b981' : '#ef4444' }}"></div>
      <div class="kpi-ico" style="background:{{ $netProfit >= 0 ? 'var(--green-l)' : 'var(--red-l)' }}">
        <svg fill="none" stroke="{{ $netProfit >= 0 ? '#34d399' : '#f87171' }}" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
        </svg>
      </div>
      <div class="kpi-lbl">Net Profit</div>
      <div class="kpi-val" style="color:{{ $netProfit >= 0 ? '#34d399' : '#f87171' }}">
        {{ ($netProfit < 0 ? '−' : '') . 'Rp ' . (abs($netProfit) >= 1e6 ? number_format(abs($netProfit) / 1e6, 1) . 'Jt' : number_format(abs($netProfit), 0, ',', '.')) }}
      </div>
      <div class="kpi-sub">@if($totalRevenue > 0) Margin {{ round($netProfit / $totalRevenue * 100, 1) }}% @else Belum ada data
      @endif</div>
    </div>
    <div class="kpi">
      <div class="kpi-glow" style="background:#3b82f6"></div>
      <div class="kpi-ico" style="background:var(--blue-l)">
        <svg fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
      </div>
      <div class="kpi-lbl">Outstanding</div>
      <div class="kpi-val" style="color:#60a5fa">
        {{ $outstandingAmount >= 1e6 ? 'Rp ' . number_format($outstandingAmount / 1e6, 1) . 'Jt' : 'Rp ' . number_format($outstandingAmount, 0, ',', '.') }}
      </div>
      <div class="kpi-sub">{{ $outstandingCount }} invoice aktif</div>
    </div>
  </div>

  {{-- Chart + Recent Invoices --}}
  <div class="g-main">
    <div class="card">
      <div class="card-hd">
        <div>
          <div class="card-title">Tren Keuangan</div>
          <div class="card-sub">Revenue vs Pengeluaran, 6 bulan terakhir</div>
        </div>
      </div>
      <div class="card-bd" style="padding:14px 18px">
        <canvas id="finChart" style="height:200px"></canvas>
      </div>
    </div>
    <div class="card" style="overflow:hidden">
      <div class="card-hd">
        <div class="card-title">Invoice Terbaru</div>
        <a href="{{ route('admin.finance.invoices.index') }}" class="btn btn-sm btn-ghost" style="font-size:11.5px">Semua
          →</a>
      </div>
      @forelse($recentInvoices as $inv)
        <div style="padding:11px 16px;border-bottom:1px solid var(--border-l);display:flex;align-items:center;gap:10px">
          <div
            style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,var(--brand),#fbbf24);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0">
            {{ strtoupper(substr($inv->client_name, 0, 2)) }}
          </div>
          <div style="min-width:0;flex:1">
            <div class="semibold trunc" style="color:var(--text);font-size:12px">{{ $inv->client_name }}</div>
            <div class="smaller muted mono">{{ $inv->invoice_number }}</div>
          </div>
          <div style="text-align:right;flex-shrink:0">
            <span class="s s-{{ $inv->status }}"
              style="margin-bottom:3px;display:inline-flex">{{ $inv->status_label }}</span>
            <div class="smaller semibold" style="color:var(--text)">{{ number_format($inv->total / 1000000, 1) }}Jt</div>
          </div>
        </div>
      @empty
        <div class="empty-state" style="padding:30px">
          <div class="empty-state-ico" style="width:44px;height:44px;margin-bottom:10px">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <p style="font-size:12px">Belum ada invoice</p>
        </div>
      @endforelse
    </div>
  </div>

  {{-- Quick Nav --}}
  <div class="card mb-24">
    <div class="card-hd">
      <div class="card-title">Akses Cepat</div>
    </div>
    <div class="card-bd">
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:10px">
        @php
          $navs = [
            ['Invoice', 'admin.finance.invoices.index', '#FB923C', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['Quotation', 'admin.finance.quotations.index', '#60A5FA', 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z'],
            ['Purchase Order', 'admin.finance.purchase-orders.index', '#A78BFA', 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
            ['Pemasukan', 'admin.finance.incomes.index', '#34D399', 'M5 10l7-7m0 0l7 7m-7-7v18'],
            ['Pengeluaran', 'admin.finance.expenses.index', '#F87171', 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
            ['Anggaran', 'admin.finance.budgets.index', '#FBBF24', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ['Bank & Kas', 'admin.finance.bank.index', '#94A3B8', 'M3 10h18M3 14h18m-9-4V6m0 8v4M5 6l7-3 7 3M5 18h14'],
            ['Komisi', 'admin.finance.commissions.index', '#FB923C', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
          ];
        @endphp
        @foreach($navs as [$label, $route, $clr, $path])
          <a href="{{ route($route) }}"
            style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 10px;border:1px solid var(--border);border-radius:12px;text-decoration:none;text-align:center;transition:all .2s;background:var(--bg3)"
            onmouseover="this.style.borderColor='{{ $clr }}40';this.style.transform='translateY(-2px)';this.style.background='var(--surface2)'"
            onmouseout="this.style.borderColor='var(--border)';this.style.transform='';this.style.background='var(--bg3)'">
            <div
              style="width:38px;height:38px;border-radius:11px;background:{{ $clr }}18;display:flex;align-items:center;justify-content:center;border:1px solid {{ $clr }}30">
              <svg style="width:16px;height:16px;color:{{ $clr }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $path }}" />
              </svg>
            </div>
            <span style="font-size:11px;font-weight:600;color:var(--text-2)">{{ $label }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Bank Accounts --}}
  @if($bankAccounts->count() > 0)
    <div class="card">
      <div class="card-hd">
        <div class="card-title">Saldo Rekening</div>
        <a href="{{ route('admin.finance.bank.index') }}" class="btn btn-sm btn-ghost">Kelola →</a>
      </div>
      <div class="card-bd">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px">
          @foreach($bankAccounts as $acc)
            <div
              style="background:var(--surface);border-radius:12px;padding:18px;position:relative;overflow:hidden;border:1px solid var(--border);box-shadow:var(--sh-sm);transition:all .2s"
              onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='var(--sh)'"
              onmouseout="this.style.transform='';this.style.boxShadow='var(--sh-sm)'">
              <div
                style="position:absolute;right:-14px;top:-14px;width:70px;height:70px;border-radius:50%;background:rgba(249,115,22,.04)">
              </div>
              <div
                style="font-size:8.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--text-3);margin-bottom:2px">
                {{ $acc->bank_name }}</div>
              <div style="font-size:11px;color:var(--text-2);margin-bottom:10px">{{ $acc->account_name }}</div>
              <div style="font-size:17px;font-weight:800;color:var(--text);letter-spacing:-.5px">
                {{ $acc->currency === 'IDR' ? 'Rp ' . number_format($acc->current_balance, 0, ',', '.') : $acc->currency . ' ' . number_format($acc->current_balance, 2) }}
              </div>
              <div style="font-family:monospace;font-size:9.5px;color:var(--text-3);margin-top:5px">{{ $acc->account_number }}
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif

@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
  <script>
    (function () {
      const ctx = document.getElementById('finChart');
      if (!ctx) return;
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: @json($chartMonths),
          datasets: [
            { label: 'Revenue', data: @json($chartRevenue), backgroundColor: 'rgba(249,115,22,.75)', borderRadius: 6, borderSkipped: false, maxBarThickness: 28 },
            { label: 'Pengeluaran', data: @json($chartExpenses), backgroundColor: 'rgba(239,68,68,.6)', borderRadius: 6, borderSkipped: false, maxBarThickness: 28 }
          ]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          plugins: {
            legend: { position: 'top', labels: { font: { size: 11, family: 'Inter' }, usePointStyle: true, pointStyleWidth: 8, padding: 16, color: '#94a3b8' } },
            tooltip: { backgroundColor: 'rgba(19,21,28,.95)', borderColor: 'rgba(255,255,255,.08)', borderWidth: 1, titleColor: '#f1f5f9', bodyColor: '#94a3b8', callbacks: { label: c => '  Rp ' + c.raw.toLocaleString('id-ID') } }
          },
          scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10.5, family: 'Inter' }, color: '#475569' }, border: { color: 'transparent' } },
            y: { grid: { color: 'rgba(255,255,255,.04)' }, border: { color: 'transparent' }, ticks: { font: { size: 10.5, family: 'Inter' }, color: '#475569', callback: v => v >= 1e6 ? 'Rp ' + (v / 1e6).toFixed(0) + 'Jt' : (v === 0 ? '0' : '') } }
          }
        }
      });
    })();
  </script>
@endpush