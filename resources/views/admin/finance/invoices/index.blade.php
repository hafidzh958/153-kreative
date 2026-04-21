@extends('admin.layouts.finance')
@section('title','Invoice & Penagihan')
@section('page-title','Invoice & Penagihan')

@section('content')
<div class="row-between mb-20">
  <div>
    <div style="font-size:18px;font-weight:800;color:var(--text);letter-spacing:-.4px">Invoice & Penagihan</div>
    <div class="muted small mt-8">Kelola tagihan dan status pembayaran klien</div>
  </div>
  <div class="row" style="gap:8px">
    <a href="{{ route('admin.finance.invoices.export', request()->only(['status','search'])) }}"
       class="btn btn-outline" title="Export ke Excel (.csv)">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
      </svg>
      Export Excel
    </a>
    <a href="{{ route('admin.finance.invoices.create') }}" class="btn btn-primary">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Buat Invoice
    </a>
  </div>
</div>

{{-- Stat strip --}}
<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:10px;margin-bottom:18px">
  @php
  $statMap = ['all'=>['Semua','#64748b'],'draft'=>['Draft','#94a3b8'],'sent'=>['Dikirim','#3b82f6'],'paid'=>['Lunas','#10b981'],'partial'=>['Sebagian','#f97316'],'overdue'=>['Overdue','#ef4444']];
  @endphp
  @foreach($statMap as $k=>[$lbl,$clr])
  <a href="{{ route('admin.finance.invoices.index',['status'=>$k]) }}"
     style="background:#fff;border:1px solid {{ request('status')===$k ? $clr : 'var(--border)' }};border-radius:10px;padding:14px 12px;text-decoration:none;transition:all .15s;{{ request('status')===$k ? 'box-shadow:0 0 0 2px '.($clr=='#64748b'?'rgba(100,116,139,.2)':'rgba(0,0,0,.06)').',' : '' }}">
    <div style="font-size:10px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px">{{ $lbl }}</div>
    <div style="font-size:20px;font-weight:800;color:{{ request('status')===$k ? $clr : 'var(--text)' }}">{{ $stats[$k] ?? 0 }}</div>
  </a>
  @endforeach
</div>

{{-- Search --}}
<form method="GET" style="display:flex;gap:8px;margin-bottom:16px;align-items:center;flex-wrap:wrap">
  <input type="hidden" name="status" value="{{ request('status') }}">
  <div class="search-bar" style="width:280px;">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari klien, nomor invoice…">
  </div>
  <button type="submit" class="btn btn-outline">Cari</button>
  @if(request('search') || request('status'))
  <a href="{{ route('admin.finance.invoices.index') }}" class="btn btn-ghost">× Reset</a>
  @endif
</form>

{{-- Table --}}
<div class="card">
  <div style="overflow-x:auto">
    <table class="tbl">
      <thead>
        <tr>
          <th>No. Invoice</th>
          <th>Klien / Event</th>
          <th>Tanggal</th>
          <th>Jatuh Tempo</th>
          <th class="tbl-right">Total</th>
          <th class="tbl-right">Terbayar</th>
          <th class="tbl-center">Status</th>
          <th class="tbl-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($invoices as $inv)
      <tr style="{{ $inv->status === 'overdue' ? 'background:#fffaf9' : '' }}">
        <td><span class="mono semibold" style="font-size:11.5px;color:var(--text)">{{ $inv->invoice_number }}</span></td>
        <td>
          <div class="semibold" style="color:var(--text)">{{ $inv->client_name }}</div>
          @if($inv->event_name)<div class="smaller muted mt-8">{{ $inv->event_name }}</div>@endif
        </td>
        <td class="muted nowrap">{{ $inv->date?->format('d M Y') ?? '—' }}</td>
        <td class="nowrap {{ $inv->status === 'overdue' ? '' : 'muted' }}" style="{{ $inv->status === 'overdue' ? 'color:#dc2626;font-weight:600' : '' }}">
          {{ $inv->due_date?->format('d M Y') ?? '—' }}
          @if($inv->status === 'overdue')
          <div style="font-size:10.5px;color:#ef4444">{{ now()->diffInDays($inv->due_date) }}h lewat</div>
          @endif
        </td>
        <td class="tbl-right semibold" style="color:var(--text)">Rp {{ number_format($inv->total,0,',','.') }}</td>
        <td class="tbl-right" style="color:{{ $inv->paid_amount > 0 ? '#16a34a' : 'var(--text-3)' }};font-weight:{{ $inv->paid_amount > 0 ? '600' : '400' }}">
          {{ $inv->paid_amount > 0 ? 'Rp '.number_format($inv->paid_amount,0,',','.') : '—' }}
        </td>
        <td class="tbl-center"><span class="s s-{{ $inv->status }}">{{ $inv->status_label }}</span></td>
        <td class="tbl-center">
          <div class="row" style="justify-content:center;gap:4px">
            <a href="{{ route('admin.finance.invoices.pdf',$inv) }}" target="_blank" class="btn btn-outline btn-sm" title="Cetak PDF">PDF</a>
            <a href="{{ route('admin.finance.invoices.show',$inv) }}" class="btn btn-outline btn-sm">Detail</a>
            <a href="{{ route('admin.finance.invoices.edit',$inv) }}" class="btn btn-outline btn-sm">Edit</a>
            @if($inv->status === 'draft')
            <form action="{{ route('admin.finance.invoices.status',$inv) }}" method="POST" style="display:inline">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="sent">
              <button type="submit" class="btn btn-sm" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe">Kirim</button>
            </form>
            @endif
            @if(in_array($inv->status,['sent','overdue','partial']))
            <button onclick="openPay({{ $inv->id }},{{ $inv->total }},{{ $inv->paid_amount }})" class="btn btn-sm" style="background:#fff7ed;color:#f97316;border:1px solid var(--orange-b)">Bayar</button>
            @endif
            <form action="{{ route('admin.finance.invoices.destroy',$inv) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus invoice {{ $inv->invoice_number }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="8">
        <div class="empty-state">
          <div class="empty-state-ico">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          </div>
          <p>Belum ada invoice</p>
          <a href="{{ route('admin.finance.invoices.create') }}" class="btn btn-primary btn-sm">Buat Invoice Pertama</a>
        </div>
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($invoices->hasPages())
  <div style="padding:12px 16px;border-top:1px solid var(--border-l)">{{ $invoices->links() }}</div>
  @endif
</div>

{{-- Pay Modal --}}
<div id="payWrap" class="modal-wrap">
  <div class="modal" style="max-width:400px">
    <div class="modal-hd">
      <div class="modal-title">Catat Pembayaran</div>
      <button class="modal-x" onclick="closePay()"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form id="payForm" method="POST">
      @csrf @method('PATCH')
      <input type="hidden" name="status" value="partial">
      <div class="modal-bd">
        <div class="fi-grp">
          <label class="fl">Jumlah Dibayar (Rp)<span class="req">*</span></label>
          <input type="number" name="paid_amount" id="payAmt" step="1" min="0" required class="fi">
          <div class="muted smaller mt-8">Total invoice: <span id="payTot" class="semibold" style="color:var(--text)"></span></div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closePay()" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openPay(id,total,paid){
  document.getElementById('payForm').action='{{ url("admin/finance/invoices") }}/'+id+'/status';
  document.getElementById('payAmt').value = total - paid;
  document.getElementById('payAmt').max = total;
  document.getElementById('payAmt').step = 1;
  document.getElementById('payTot').textContent = 'Rp ' + total.toLocaleString('id-ID');
  document.getElementById('payWrap').classList.add('open');
}
function closePay(){ document.getElementById('payWrap').classList.remove('open'); }
document.getElementById('payWrap').addEventListener('click', function(e){ if(e.target===this) closePay(); });
</script>
@endpush
