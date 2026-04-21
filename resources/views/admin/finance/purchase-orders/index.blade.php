@extends('admin.layouts.finance')
@section('title','Purchase Order')
@section('page-title','Purchase Order')

@section('content')
<div class="row-between mb-20">
  <div>
    <div style="font-size:18px;font-weight:800;color:var(--text);letter-spacing:-.4px">Purchase Order</div>
    <div class="muted small mt-8">Kelola PO ke vendor dan persetujuan</div>
  </div>
  <button onclick="openM('mCreate')" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Buat PO
  </button>
</div>

@if($pending->count() > 0)
<div class="alert alert-warn mb-16">
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
  <strong>{{ $pending->count() }} PO menunggu persetujuan</strong>
</div>
@endif

<div class="row mb-16" style="flex-wrap:wrap;gap:6px">
  @foreach(['all'=>'Semua','pending'=>'Menunggu','approved'=>'Disetujui','paid'=>'Lunas','rejected'=>'Ditolak'] as $k=>$v)
  <a href="{{ route('admin.finance.purchase-orders.index',['status'=>$k]) }}" class="pill {{ request('status')===$k ? 'on' : '' }}">{{ $v }} <span style="opacity:.6">({{ $stats[$k] ?? 0 }})</span></a>
  @endforeach
</div>

<div class="card">
  <div style="overflow-x:auto">
    <table class="tbl">
      <thead>
        <tr>
          <th>No. PO</th><th>Vendor</th><th>Kategori</th><th>Keperluan</th><th>Tanggal</th>
          <th class="tbl-right">Nilai</th><th class="tbl-center">Status</th><th class="tbl-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($pos as $po)
      <tr>
        <td><span class="mono semibold" style="font-size:11.5px">{{ $po->po_number }}</span></td>
        <td>
          <div class="semibold" style="color:var(--text)">{{ $po->vendor_name }}</div>
          @if($po->vendor_email)<div class="smaller muted">{{ $po->vendor_email }}</div>@endif
        </td>
        <td>
          <span style="background:#f1f5f9;padding:2px 7px;border-radius:5px;font-size:11px;font-weight:600;color:var(--text-2)">
            {{ $po->category_label }}
          </span>
        </td>
        <td class="muted" style="max-width:180px">{{ Str::limit($po->description ?? '—', 35) }}</td>
        <td class="muted nowrap">{{ $po->date?->format('d M Y') }}</td>
        <td class="tbl-right semibold" style="color:var(--text)">Rp {{ number_format($po->amount,0,',','.') }}</td>
        <td class="tbl-center"><span class="s s-{{ $po->status }}">{{ $po->status_label }}</span></td>
        <td class="tbl-center">
          <div class="row" style="justify-content:center;gap:4px">
            @if($po->status === 'pending')
            <form action="{{ route('admin.finance.purchase-orders.approve',$po) }}" method="POST" style="display:inline">
              @csrf<button type="submit" class="btn btn-sm" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0">✓ Setuju</button>
            </form>
            <form action="{{ route('admin.finance.purchase-orders.reject',$po) }}" method="POST" style="display:inline" onsubmit="return confirm('Tolak PO ini?')">
              @csrf<button type="submit" class="btn btn-sm btn-danger">✕ Tolak</button>
            </form>
            @endif
            @if($po->status === 'approved')
            <form action="{{ route('admin.finance.purchase-orders.payment',$po) }}" method="POST" style="display:inline">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-sm" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0">Tandai Lunas</button>
            </form>
            @endif
            <form action="{{ route('admin.finance.purchase-orders.destroy',$po) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus PO ini?')">
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
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          </div>
          <p>Belum ada purchase order</p>
          <button onclick="openM('mCreate')" class="btn btn-primary btn-sm">Buat PO Pertama</button>
        </div>
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($pos->hasPages())<div style="padding:12px 16px;border-top:1px solid var(--border-l)">{{ $pos->links() }}</div>@endif
</div>

{{-- Create Modal --}}
<div id="mCreate" class="modal-wrap">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-title">Buat Purchase Order</div>
      <button class="modal-x" onclick="closeM('mCreate')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form action="{{ route('admin.finance.purchase-orders.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="g2">
          <div class="fi-grp"><label class="fl">Nama Vendor<span class="req">*</span></label><input type="text" name="vendor_name" required class="fi" placeholder="CV. Vendor Terpercaya"></div>
          <div class="fi-grp"><label class="fl">Kategori<span class="req">*</span></label>
            <select name="category" required class="fi">
              <option value="">Pilih Kategori…</option>
              <option value="venue">Venue</option>
              <option value="catering">Catering / F&B</option>
              <option value="av">AV / Multimedia</option>
              <option value="decoration">Dekorasi</option>
              <option value="transport">Transportasi</option>
              <option value="talent">Talent / Artis</option>
              <option value="marketing">Marketing</option>
              <option value="other">Lainnya</option>
            </select>
          </div>
          <div class="fi-grp"><label class="fl">Nilai PO (Rp)<span class="req">*</span></label><input type="number" name="amount" step="1000" min="0" required class="fi" placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Tanggal<span class="req">*</span></label><input type="date" name="date" value="{{ now()->toDateString() }}" required class="fi"></div>
          <div class="fi-grp"><label class="fl">Email Vendor</label><input type="email" name="vendor_email" class="fi" placeholder="vendor@email.com"></div>
          <div class="fi-grp"><label class="fl">Nama Event</label><input type="text" name="event_name" class="fi" placeholder="Nama event terkait"></div>
          <div class="fi-grp gc2"><label class="fl">Deskripsi / Keperluan</label><textarea name="description" rows="2" class="fi" style="resize:none" placeholder="Sewa venue 3 hari, termasuk setup & breakdown…"></textarea></div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closeM('mCreate')" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan PO</button>
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
