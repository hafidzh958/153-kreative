@extends('admin.layouts.finance')
@section('title','Edit Invoice')
@section('page-title','Edit Invoice')

@section('content')
<div class="row mb-20" style="gap:10px">
  <a href="{{ route('admin.finance.invoices.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
  <span class="muted">/</span>
  <span class="semibold small mono" style="color:var(--ios-orange)">{{ $invoice->invoice_number }}</span>
</div>

@if(isset($errors) && $errors->any())
<div class="alert alert-err mb-16">
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
  <div><strong>Mohon perbaiki:</strong><ul style="margin-top:4px;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
</div>
@endif

<form action="{{ route('admin.finance.invoices.update', $invoice) }}" method="POST">
@csrf @method('PUT')
<div class="card">
  <div class="card-hd">
    <div>
      <div class="card-title">Edit Invoice</div>
      <div class="card-sub">No: <span class="mono semibold" style="color:var(--ios-orange)">{{ $invoice->invoice_number }}</span></div>
    </div>
    <select name="status" class="fi" style="width:auto">
      @foreach(['draft'=>'Draft','sent'=>'Dikirim','paid'=>'Lunas','overdue'=>'Overdue','partial'=>'Sebagian'] as $v=>$l)
        <option value="{{ $v }}" {{ old('status',$invoice->status) === $v ? 'selected' : '' }}>{{ $l }}</option>
      @endforeach
    </select>
  </div>

  <div class="card-bd">

    {{-- ── Klien ── --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--label-3);margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--sep-opaque)">Informasi Klien</div>
    <div class="g2 mb-16">
      <div class="fi-grp">
        <label class="fl">Nama Perusahaan / Klien<span class="req">*</span></label>
        <input type="text" name="client_name" value="{{ old('client_name',$invoice->client_name) }}" required class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">Jenis / Merk Product</label>
        <input type="text" name="product_type" value="{{ old('product_type',$invoice->product_type) }}" class="fi" placeholder="Mobil / Toyota">
      </div>
      <div class="fi-grp gc2">
        <label class="fl">Alamat Lengkap Kantor</label>
        <input type="text" name="client_address" value="{{ old('client_address',$invoice->client_address) }}" class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">Penanggungjawab (PIC Klien)</label>
        <input type="text" name="client_pic" value="{{ old('client_pic',$invoice->client_pic) }}" class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">No. Telepon</label>
        <input type="text" name="client_phone" value="{{ old('client_phone',$invoice->client_phone) }}" class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">Email Klien</label>
        <input type="email" name="client_email" value="{{ old('client_email',$invoice->client_email) }}" class="fi">
      </div>
    </div>

    {{-- ── Event ── --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--label-3);margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--sep-opaque)">Detail Event / Pameran</div>
    <div class="g2 mb-16">
      <div class="fi-grp gc2">
        <label class="fl">Nama Event</label>
        <input type="text" name="event_name" value="{{ old('event_name',$invoice->event_name) }}" class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">Tanggal Event Mulai</label>
        <input type="text" name="event_date_start" value="{{ old('event_date_start',$invoice->event_date_start) }}" class="fi" placeholder="17 April 2026">
      </div>
      <div class="fi-grp">
        <label class="fl">Tanggal Event Selesai</label>
        <input type="text" name="event_date_end" value="{{ old('event_date_end',$invoice->event_date_end) }}" class="fi" placeholder="19 April 2026">
      </div>
      <div class="fi-grp">
        <label class="fl">Venue / Lokasi</label>
        <input type="text" name="venue" value="{{ old('venue',$invoice->venue) }}" class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">Space / Ukuran Stand</label>
        <input type="text" name="space" value="{{ old('space',$invoice->space) }}" class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">No. Surat Penawaran Referensi</label>
        <input type="text" name="ref_quotation" value="{{ old('ref_quotation',$invoice->ref_quotation) }}" class="fi">
      </div>
    </div>

    {{-- ── Tanggal ── --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--label-3);margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--sep-opaque)">Tanggal & Pembayaran</div>
    <div class="g2 mb-16">
      <div class="fi-grp">
        <label class="fl">Tanggal Invoice<span class="req">*</span></label>
        <input type="date" name="date" value="{{ old('date',$invoice->date?->toDateString()) }}" required class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">Jatuh Tempo<span class="req">*</span></label>
        <input type="date" name="due_date" value="{{ old('due_date',$invoice->due_date?->toDateString()) }}" required class="fi">
      </div>
    </div>

    {{-- ── Harga ── --}}
    <div style="background:var(--fill-4);border:1px solid var(--sep-opaque);border-radius:10px;padding:16px;margin-bottom:16px">
      <div class="g2 mb-12">
        <div class="fi-grp" style="margin-bottom:0">
          <label class="fl">Subtotal / Harga (Rp)<span class="req">*</span></label>
          <input type="number" name="subtotal" id="sub" value="{{ old('subtotal',(int)$invoice->subtotal) }}" step="1" min="0" required oninput="calc()" class="fi">
        </div>
        <div class="fi-grp" style="margin-bottom:0">
          <label class="fl">PPN (%)</label>
          <div class="row" style="gap:10px;align-items:center">
            <input type="number" name="tax_rate" id="tax" value="{{ old('tax_rate',(float)$invoice->tax_rate) }}" step="0.5" min="0" max="100" oninput="calc()" class="fi">
            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;white-space:nowrap;font-size:13px;font-weight:600;color:var(--ios-red)">
              <input type="checkbox" name="is_non_tax" id="nonTax" value="1" {{ old('is_non_tax',$invoice->is_non_tax) ? 'checked' : '' }} onchange="calc()"> NON TAX
            </label>
          </div>
        </div>
      </div>
      <div style="border-top:1px solid var(--sep-opaque);padding-top:12px;display:flex;flex-direction:column;gap:6px">
        <div class="row-between small"><span class="muted">Subtotal</span><span id="dSub" class="semibold">Rp 0</span></div>
        <div class="row-between small" id="taxRow"><span class="muted">PPN</span><span id="dTax" class="semibold">Rp 0</span></div>
        <div class="row-between" style="font-weight:800;font-size:15px;border-top:1px solid var(--sep-opaque);padding-top:8px;margin-top:2px">
          <span>Total</span><span id="dTot" style="color:var(--ios-blue)">Rp 0</span>
        </div>
      </div>
    </div>

    {{-- ── Bank & Lainnya ── --}}
    <div class="g2 mb-16">
      <div class="fi-grp">
        <label class="fl">Sudah Dibayar (Rp)</label>
        <input type="number" name="paid_amount" value="{{ old('paid_amount',(int)$invoice->paid_amount) }}" step="1" min="0" class="fi">
      </div>
      <div class="fi-grp">
        <label class="fl">Info Rekening Bank</label>
        <textarea name="bank_account" rows="3" class="fi" style="resize:none;font-family:monospace;font-size:12.5px" placeholder="Bank BCA&#10;134.324.7617&#10;Satu Lima Tiga PT">{{ old('bank_account',$invoice->bank_account) }}</textarea>
        <div class="muted smaller mt-8">Baris 1: Nama Bank · Baris 2: No. Rekening · Baris 3: Atas Nama</div>
      </div>
    </div>

    <div class="fi-grp mb-16">
      <label class="fl">Catatan</label>
      <textarea name="notes" rows="2" class="fi" style="resize:none">{{ old('notes',$invoice->notes) }}</textarea>
    </div>

    <div class="row" style="border-top:1px solid var(--sep-opaque);padding-top:16px;justify-content:flex-end;gap:8px">
      <a href="{{ route('admin.finance.invoices.index') }}" class="btn btn-outline">Batal</a>
      <button type="submit" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Simpan Perubahan
      </button>
    </div>
  </div>
</div>
</form>
@endsection

@push('scripts')
<script>
function fmt(v){ return 'Rp ' + Math.round(v).toLocaleString('id-ID') }
function calc(){
  const s    = parseFloat(document.getElementById('sub').value)||0;
  const nonT = document.getElementById('nonTax').checked;
  const r    = nonT ? 0 : (parseFloat(document.getElementById('tax').value)||0);
  const t    = Math.round(s * r / 100);
  document.getElementById('dSub').textContent = fmt(s);
  document.getElementById('dTax').textContent = nonT ? '– (NON TAX)' : fmt(t);
  document.getElementById('dTot').textContent = fmt(s + t);
  document.getElementById('taxRow').style.opacity = nonT ? '.4' : '1';
}
calc();
</script>
@endpush
