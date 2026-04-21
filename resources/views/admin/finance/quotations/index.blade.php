@extends('admin.layouts.finance')
@section('title','Quotation')
@section('page-title','Quotation / Penawaran')

@section('content')

{{-- Page Header --}}
<div class="row-between mb-24">
  <div class="page-hd" style="margin:0">
    <h1>Quotation</h1>
    <p>Buat dan kelola penawaran harga untuk klien</p>
  </div>
  <div class="row" style="gap:8px">
    <a href="{{ route('admin.finance.quotations.export', request()->only(['status'])) }}"
       class="btn btn-outline" title="Export ke Excel (.csv)">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
      </svg>
      Export Excel
    </a>
    <button onclick="openM('mCreate')" class="btn btn-primary">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Buat Quotation
    </button>
  </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="alert alert-err mb-20">
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
  <div>
    <strong>Gagal menyimpan:</strong>
    <ul style="margin-top:4px;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
</div>
@endif

{{-- Info Box: Penjelasan alur bisnis --}}
<div class="info-box mb-20">
  <div style="font-weight:700;margin-bottom:10px;font-size:12.5px">📋 Alur Quotation — Event Organizer</div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:10px;font-size:11.5px">
    <div style="display:flex;gap:8px;align-items:flex-start">
      <span style="background:rgba(148,163,184,.15);color:#94a3b8;font-weight:700;padding:2px 8px;border-radius:5px;font-size:10.5px;flex-shrink:0;margin-top:1px">1 · Draft</span>
      <span style="color:var(--text-2)">Quotation baru dibuat, <strong>belum</strong> dikirim ke klien. Bisa diedit bebas.</span>
    </div>
    <div style="display:flex;gap:8px;align-items:flex-start">
      <span style="background:rgba(59,130,246,.12);color:#60a5fa;font-weight:700;padding:2px 8px;border-radius:5px;font-size:10.5px;flex-shrink:0;margin-top:1px">2 · Dikirim</span>
      <span style="color:var(--text-2)">Sudah dikirim/dibagikan ke <strong>klien</strong>, menunggu respons mereka.</span>
    </div>
    <div style="display:flex;gap:8px;align-items:flex-start">
      <span style="background:rgba(16,185,129,.12);color:#34d399;font-weight:700;padding:2px 8px;border-radius:5px;font-size:10.5px;flex-shrink:0;margin-top:1px">3 · Disetujui</span>
      <span style="color:var(--text-2)"><strong>Klien setuju</strong> dengan harga. Tandai ini lalu konversi ke Invoice.</span>
    </div>
    <div style="display:flex;gap:8px;align-items:flex-start">
      <span style="background:rgba(239,68,68,.12);color:#f87171;font-weight:700;padding:2px 8px;border-radius:5px;font-size:10.5px;flex-shrink:0;margin-top:1px">✗ Ditolak</span>
      <span style="color:var(--text-2)"><strong>Klien menolak</strong> penawaran (harga terlalu mahal, batal, dll). Quotation tidak dilanjutkan.</span>
    </div>
    <div style="display:flex;gap:8px;align-items:flex-start">
      <span style="background:rgba(139,92,246,.12);color:#a78bfa;font-weight:700;padding:2px 8px;border-radius:5px;font-size:10.5px;flex-shrink:0;margin-top:1px">✓ Dikonversi</span>
      <span style="color:var(--text-2)">Sudah diubah menjadi Invoice. Data klien & total <strong>otomatis tersalin</strong>. Quotation ini terkunci.</span>
    </div>
  </div>
</div>

{{-- KPI Stats --}}
<div class="g3 mb-24" style="grid-template-columns:repeat(auto-fill,minmax(140px,1fr))">
  @foreach(['all'=>['Semua','#f97316','rgba(249,115,22,.12)'],'draft'=>['Draft','#94a3b8','rgba(148,163,184,.1)'],'sent'=>['Dikirim','#60a5fa','rgba(59,130,246,.12)'],'approved'=>['Disetujui','#34d399','rgba(16,185,129,.12)'],'converted'=>['Dikonversi','#a78bfa','rgba(139,92,246,.12)'],'rejected'=>['Ditolak','#f87171','rgba(239,68,68,.12)']] as $k=>[$label,$clr,$bg])
  <a href="{{ route('admin.finance.quotations.index',['status'=>$k]) }}" style="text-decoration:none">
    <div class="kpi" style="padding:14px;{{ request('status')===$k ? 'border-color:'.$clr.';box-shadow:0 0 0 1px '.$clr : '' }}">
      <div style="font-size:10px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px">{{ $label }}</div>
      <div style="font-size:26px;font-weight:800;color:{{ $clr }}">{{ $stats[$k] ?? 0 }}</div>
      <div style="font-size:10px;color:var(--text-3);margin-top:3px">quotation</div>
    </div>
  </a>
  @endforeach
</div>

{{-- Filter Pills --}}
<div class="row mb-16" style="flex-wrap:wrap;gap:6px">
  @foreach(['all'=>'Semua','draft'=>'Draft','sent'=>'Dikirim','approved'=>'Disetujui','converted'=>'Dikonversi','rejected'=>'Ditolak'] as $k=>$v)
  <a href="{{ route('admin.finance.quotations.index',['status'=>$k]) }}" class="pill {{ (request('status')===$k || (!request('status') && $k==='all')) ? 'on' : '' }}">
    {{ $v }} <span class="pill-count">{{ $stats[$k] ?? 0 }}</span>
  </a>
  @endforeach
</div>

{{-- Table --}}
<div class="card">
  <div style="overflow-x:auto">
    <table class="tbl">
      <thead>
        <tr>
          <th>No. Quotation</th>
          <th>Klien / Event</th>
          <th>Tanggal</th>
          <th>Berlaku s/d</th>
          <th class="tbl-right">Subtotal</th>
          <th class="tbl-right">PPN</th>
          <th class="tbl-right">Total</th>
          <th class="tbl-center">Status</th>
          <th class="tbl-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($quotations as $q)
      <tr>
        <td>
          <span class="mono semibold" style="font-size:11.5px;color:var(--brand)">{{ $q->quotation_number }}</span>
        </td>
        <td>
          <div class="semibold" style="color:var(--text)">{{ $q->client_name }}</div>
          @if($q->event_name)<div class="smaller muted" style="margin-top:2px">📋 {{ $q->event_name }}</div>@endif
          @if($q->client_email)<div class="smaller muted">✉ {{ $q->client_email }}</div>@endif
        </td>
        <td class="muted nowrap">{{ $q->date?->format('d M Y') }}</td>
        <td class="muted nowrap">
          @if($q->valid_until)
            @php $expired = $q->valid_until < now() && !in_array($q->status, ['converted','rejected']); @endphp
            <span style="color:{{ $expired ? '#f87171' : 'var(--text-3)' }}">
              {{ $q->valid_until->format('d M Y') }}
              @if($expired) <span class="tag" style="background:rgba(239,68,68,.1);color:#f87171;margin-left:2px">Exp</span>@endif
            </span>
          @else
            <span class="muted">—</span>
          @endif
        </td>
        <td class="tbl-right muted" style="font-size:12px">Rp {{ number_format($q->subtotal,0,',','.') }}</td>
        <td class="tbl-right muted" style="font-size:11px">
          {{ $q->tax_rate }}% <br><span style="font-size:10.5px">Rp {{ number_format($q->tax_amount,0,',','.') }}</span>
        </td>
        <td class="tbl-right semibold" style="color:var(--text);font-size:13px">
          Rp {{ number_format($q->total,0,',','.') }}
        </td>
        <td class="tbl-center">
          <span class="s s-{{ $q->status }}">{{ $q->status_label }}</span>
        </td>
        <td class="tbl-center">
          <div class="row" style="justify-content:center;gap:6px">
            {{-- Cetak PDF --}}
            <a href="{{ route('admin.finance.quotations.pdf', $q) }}" target="_blank" class="btn btn-xs btn-outline" title="Cetak PDF">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
              PDF
            </a>
            {{-- Status Change --}}
            @if(!in_array($q->status, ['converted']))
            <button onclick="openStatusModal({{ $q->id }}, '{{ $q->status }}', '{{ $q->quotation_number }}')"
              class="btn btn-xs btn-outline" title="Ubah Status">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
              Status
            </button>
            @endif
            {{-- Convert to Invoice --}}
            @if($q->status === 'approved')
            <form action="{{ route('admin.finance.quotations.convert',$q) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Konversi Quotation {{ $q->quotation_number }} ke Invoice?\n\nData client, total, dan PPN akan otomatis disalin.')">
              @csrf
              <button type="submit" class="btn btn-xs btn-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                → Invoice
              </button>
            </form>
            @endif
            {{-- Delete --}}
            @if(!in_array($q->status, ['converted']))
            <form action="{{ route('admin.finance.quotations.destroy',$q) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Hapus Quotation {{ $q->quotation_number }}?\n\nTindakan ini tidak bisa dibatalkan.')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-xs btn-danger">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus
              </button>
            </form>
            @else
            <span class="btn btn-xs" style="background:rgba(139,92,246,.1);color:#a78bfa;border:1px solid rgba(139,92,246,.2);cursor:default">✓ Dikonversi</span>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="9">
        <div class="empty-state">
          <div class="empty-state-ico">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
          </div>
          <p>Belum ada quotation {{ request('status') && request('status') !== 'all' ? 'dengan status '.request('status') : '' }}</p>
          <button onclick="openM('mCreate')" class="btn btn-primary btn-sm">Buat Quotation Pertama</button>
        </div>
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($quotations->hasPages())
  <div style="padding:12px 16px;border-top:1px solid var(--border-l)">{{ $quotations->links() }}</div>
  @endif
</div>

{{-- Create Modal --}}
<div id="mCreate" class="modal-wrap">
  <div class="modal">
    <div class="modal-hd">
      <div>
        <div class="modal-title">Buat Quotation Baru</div>
        <div class="modal-subtitle">Penawaran akan disimpan dengan status Draft</div>
      </div>
      <button class="modal-x" onclick="closeM('mCreate')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form action="{{ route('admin.finance.quotations.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="g2">
          <div class="fi-grp">
            <label class="fl">Nama Klien <span class="req">*</span></label>
            <input type="text" name="client_name" required class="fi" placeholder="PT. Contoh Jaya">
          </div>
          <div class="fi-grp">
            <label class="fl">Email Klien</label>
            <input type="email" name="client_email" class="fi" placeholder="klien@email.com">
          </div>
          <div class="fi-grp gc2">
            <label class="fl">Nama Event / Proyek</label>
            <input type="text" name="event_name" class="fi" placeholder="Misal: Annual Gathering 2025, Wedding XYZ">
          </div>
          <div class="fi-grp">
            <label class="fl">Subtotal (Rp) <span class="req">*</span></label>
            <input type="number" name="subtotal" id="subtotal_in" step="1" min="0" required class="fi" placeholder="0" oninput="calcTotal()">
          </div>
          <div class="fi-grp">
            <label class="fl">PPN (%)</label>
            <input type="number" name="tax_rate" id="tax_rate_in" value="{{ $taxRate ?? 11 }}" step="0.5" min="0" max="100" class="fi" oninput="calcTotal()">
          </div>
          {{-- Preview Total --}}
          <div class="fi-grp gc2">
            <div id="total-preview" style="background:var(--bg3);border:1px solid var(--border-l);border-radius:9px;padding:12px 14px;display:flex;justify-content:space-between;align-items:center">
              <span style="font-size:12px;color:var(--text-2)">Total setelah PPN</span>
              <span id="total-display" style="font-size:16px;font-weight:800;color:var(--brand)">Rp 0</span>
            </div>
          </div>
          <div class="fi-grp">
            <label class="fl">Berlaku Hingga <span class="req">*</span></label>
            <input type="date" name="valid_until" value="{{ now()->addDays(14)->toDateString() }}" required class="fi">
          </div>
          <div class="fi-grp">
            <label class="fl">Tanggal</label>
            <input type="date" name="date" value="{{ now()->toDateString() }}" class="fi">
          </div>
          <div class="fi-grp gc2">
            <label class="fl">Catatan / Syarat & Ketentuan</label>
            <textarea name="notes" rows="3" class="fi" style="resize:vertical" placeholder="Syarat & ketentuan, catatan khusus untuk klien..."></textarea>
          </div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closeM('mCreate')" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Simpan Quotation
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Status Change Modal --}}
<div id="mStatus" class="modal-wrap">
  <div class="modal" style="max-width:420px">
    <div class="modal-hd">
      <div>
        <div class="modal-title">Perbarui Status Quotation</div>
        <div class="modal-subtitle" id="status-modal-qnum">—</div>
      </div>
      <button class="modal-x" onclick="closeM('mStatus')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form id="statusForm" method="POST">
      @csrf @method('PATCH')
      <div class="modal-bd">
        <div class="fi-grp">
          <label class="fl">Status Respons Klien <span class="req">*</span></label>
          <select name="status" id="status_select" required class="fi">
            <option value="draft">📝 Draft — Belum dikirim ke klien</option>
            <option value="sent">📤 Dikirim — Sudah dikirimkan ke klien, menunggu jawaban</option>
            <option value="approved">✅ Disetujui — Klien menyetujui penawaran ini</option>
            <option value="rejected">❌ Ditolak — Klien menolak / tidak jadi</option>
          </select>
        </div>
        <div id="status-hint" class="muted smaller" style="margin-top:8px;padding:8px 12px;background:var(--bg3);border-radius:8px;border:1px solid var(--border-l)"></div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closeM('mStatus')" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Status</button>
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

@if($errors->any())
  window.addEventListener('DOMContentLoaded', () => openM('mCreate'));
@endif

// Live total calculation
function calcTotal() {
  const sub = parseFloat(document.getElementById('subtotal_in').value) || 0;
  const rate = parseFloat(document.getElementById('tax_rate_in').value) || 0;
  const tax = sub * rate / 100;
  const total = sub + tax;
  document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

const statusHints = {
  draft:    '📝 Quotation masih di tahap draft. Anda bisa edit kapan saja sebelum dikirim ke klien.',
  sent:     '📤 Anda sudah mengirimkan penawaran ini ke klien. Sekarang menunggu respons dari klien (setuju atau tolak).',
  approved: '✅ <strong>Klien menyetujui penawaran ini.</strong> Anda bisa langsung menekan tombol "→ Invoice" untuk membuat Invoice dari quotation ini.',
  rejected: '❌ <strong>Klien menolak penawaran ini</strong> — misalnya harga tidak sesuai, klien batal, atau memilih vendor lain. Quotation akan ditandai tutup.',
};
function updateStatusHint() {
  const sel  = document.getElementById('status_select');
  const hint = document.getElementById('status-hint');
  if (sel && hint) hint.innerHTML = statusHints[sel.value] || '';
}
function openStatusModal(id, currentStatus, qnum) {
  document.getElementById('status-modal-qnum').textContent = qnum;
  document.getElementById('status_select').value = currentStatus;
  document.getElementById('statusForm').action = '{{ url("admin/finance/quotations") }}/' + id + '/status';
  updateStatusHint();
  openM('mStatus');
}
document.addEventListener('DOMContentLoaded', () => {
  const sel = document.getElementById('status_select');
  if (sel) sel.addEventListener('change', updateStatusHint);
});
</script>
@endpush
