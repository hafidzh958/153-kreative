@extends('admin.layouts.finance')
@section('title','Komisi')
@section('page-title','Komisi & Insentif')

@section('content')
<div class="row-between mb-20">
  <div>
    <div style="font-size:18px;font-weight:800;color:var(--text);letter-spacing:-.4px">Komisi & Insentif</div>
    <div class="muted small mt-8">Kelola komisi tim sales dan operasional</div>
  </div>
  <button onclick="openM('mCreate')" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Buat Komisi
  </button>
</div>

<div class="g2 mb-20">
  <div class="kpi">
    <div class="kpi-glow" style="background:#10b981"></div>
    <div class="kpi-ico" style="background:rgba(16,185,129,.12)"><svg fill="none" stroke="#34d399" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
    <div class="kpi-lbl">Total Terbayar</div>
    <div class="kpi-val" style="color:#34d399">Rp {{ $totalPaid >= 1000000 ? number_format($totalPaid/1000000,1).' Jt' : number_format($totalPaid,0,',','.') }}</div>
  </div>
  <div class="kpi">
    <div class="kpi-glow" style="background:#f59e0b"></div>
    <div class="kpi-ico" style="background:rgba(245,158,11,.12)"><svg fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
    <div class="kpi-lbl">Menunggu Pembayaran</div>
    <div class="kpi-val" style="color:#fbbf24">Rp {{ $totalPending >= 1000000 ? number_format($totalPending/1000000,1).' Jt' : number_format($totalPending,0,',','.') }}</div>
  </div>
</div>

<div class="card">
  <div style="overflow-x:auto">
    <table class="tbl">
      <thead>
        <tr><th>Nama</th><th>Peran</th><th>Event</th><th class="tbl-right">Revenue</th><th class="tbl-right">Komisi</th><th class="tbl-center">Status</th><th class="tbl-center">Aksi</th></tr>
      </thead>
      <tbody>
      @forelse($commissions as $c)
      <tr>
        <td>
          <div class="semibold" style="color:var(--text)">{{ $c->employee_name }}</div>
          @if($c->employee_division)<div class="smaller muted">{{ $c->employee_division }}</div>@endif
        </td>
        <td><span style="background:#f1f5f9;padding:2px 7px;border-radius:5px;font-size:11px;font-weight:600;color:var(--text-2);text-transform:capitalize">{{ $c->typeLabel }}</span></td>
        <td class="muted smaller">{{ $c->event_name ?? '—' }}</td>
        <td class="tbl-right muted">Rp {{ number_format($c->revenue_amount,0,',','.') }}</td>
        <td class="tbl-right semibold" style="color:var(--text)">Rp {{ number_format($c->commission_amount,0,',','.') }}</td>
        <td class="tbl-center"><span class="s s-{{ $c->status }}">{{ $c->statusLabel }}</span></td>
        <td class="tbl-center">
          <div class="row" style="justify-content:center;gap:4px">
            @if($c->status === 'pending')
            <form action="{{ route('admin.finance.commissions.approve',$c) }}" method="POST" style="display:inline">
              @csrf<button type="submit" class="btn btn-sm" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0">✓ Setuju</button>
            </form>
            @endif
            @if($c->status === 'approved')
            <form action="{{ route('admin.finance.commissions.pay',$c) }}" method="POST" style="display:inline">
              @csrf<button type="submit" class="btn btn-sm btn-primary">Bayar</button>
            </form>
            @endif
            <form action="{{ route('admin.finance.commissions.destroy',$c) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus komisi ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7">
        <div class="empty-state">
          <div class="empty-state-ico">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <p>Belum ada komisi tercatat</p>
        </div>
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($commissions->hasPages())<div style="padding:12px 16px;border-top:1px solid var(--border-l)">{{ $commissions->links() }}</div>@endif
</div>

<div id="mCreate" class="modal-wrap">
  <div class="modal" style="max-width:440px">
    <div class="modal-hd"><div class="modal-title">Buat Komisi</div><button class="modal-x" onclick="closeM('mCreate')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
    <form action="{{ route('admin.finance.commissions.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="g2">
          <div class="fi-grp"><label class="fl">Nama Staff<span class="req">*</span></label><input type="text" name="employee_name" required class="fi" placeholder="Nama lengkap"></div>
          <div class="fi-grp"><label class="fl">Divisi</label>
            <select name="type" class="fi"><option value="sales">Sales</option><option value="operation">Operasional</option><option value="bonus">Bonus</option><option value="incentive">Insentif</option></select>
          </div>
          <div class="fi-grp"><label class="fl">Revenue Event (Rp)<span class="req">*</span></label><input type="number" name="revenue_amount" step="1000" min="0" required class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Rate Komisi (%)<span class="req">*</span></label><input type="number" name="rate" step="0.5" min="0" max="100" value="{{ $salesRate }}" required class="fi"></div>
          <div class="fi-grp gc2"><label class="fl">Nama Event</label><input type="text" name="event_name" class="fi" placeholder="Nama event terkait"></div>
        </div>
      </div>
      <div class="modal-ft"><button type="button" onclick="closeM('mCreate')" class="btn btn-outline">Batal</button><button type="submit" class="btn btn-primary">Simpan Komisi</button></div>
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
