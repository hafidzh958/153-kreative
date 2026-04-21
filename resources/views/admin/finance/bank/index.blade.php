@extends('admin.layouts.finance')
@section('title','Bank & Kas')
@section('page-title','Bank & Kas')

@section('content')

{{-- Page Header --}}
<div class="row-between mb-24">
  <div class="page-hd" style="margin:0">
    <h1>Bank &amp; Kas</h1>
    <p>Manajemen rekening bank, kas, dan pencatatan mutasi keuangan masuk/keluar</p>
  </div>
  <div class="row" style="gap:8px">
    <button onclick="openM('mMutation')" class="btn btn-outline">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
      Catat Mutasi
    </button>
    <button onclick="openM('mAccount')" class="btn btn-primary">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tambah Rekening
    </button>
  </div>
</div>

{{-- Info Box --}}
<div class="info-box mb-24">
  <strong>💡 Bank &amp; Kas digunakan untuk:</strong><br>
  Mencatat semua <strong>rekening bank dan kas tunai</strong> yang dimiliki perusahaan, serta merekam setiap
  <strong>mutasi / transaksi</strong> (masuk/keluar). Ini berbeda dari Pemasukan (income dari klien) —
  Bank &amp; Kas lebih ke saldo rekening dan arus kas aktual.
  Setiap mutasi yang dicatat akan <strong>otomatis memperbarui saldo rekening</strong> secara real-time.
</div>

{{-- Total Balance Card --}}
@if($totalIDR > 0)
<div style="background:linear-gradient(135deg,rgba(249,115,22,.12),rgba(251,191,36,.08));border:1px solid rgba(249,115,22,.25);border-radius:14px;padding:20px 24px;display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;position:relative;overflow:hidden">
  <div style="position:absolute;right:-20px;top:-20px;width:120px;height:120px;border-radius:50%;background:rgba(249,115,22,.06)"></div>
  <div>
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--brand);opacity:.8;margin-bottom:4px">Total Saldo Rekening (IDR)</div>
    <div style="font-size:28px;font-weight:900;color:var(--brand);letter-spacing:-.7px">Rp {{ number_format($totalIDR,0,',','.') }}</div>
    <div style="font-size:11.5px;color:var(--text-2);margin-top:4px">{{ $accounts->count() }} rekening aktif</div>
  </div>
  <div style="opacity:.18">
    <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M3 14h18m-9-4V6m0 8v4M5 6l7-3 7 3M5 18h14"/></svg>
  </div>
</div>
@endif

{{-- Account Cards --}}
@if($accounts->count())
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px;margin-bottom:28px">
  @foreach($accounts as $i => $acc)
  <div style="background:var(--surface);border-radius:16px;padding:22px;position:relative;overflow:hidden;border:1px solid var(--border);box-shadow:var(--sh-sm);transition:all .2s" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='var(--sh);border-color:var(--brand)'" onmouseout="this.style.transform='';this.style.boxShadow='var(--sh-sm)';this.style.borderColor='var(--border)'">
    {{-- Decorative circles --}}
    <div style="position:absolute;right:-20px;top:-20px;width:100px;height:100px;border-radius:50%;background:rgba(249,115,22,.04)"></div>
    <div style="position:absolute;left:-30px;bottom:-30px;width:120px;height:120px;border-radius:50%;background:rgba(59,130,246,.03)"></div>
    <div style="position:relative">
      <div style="font-size:9.5px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--brand);margin-bottom:2px">{{ $acc->bank_name }}</div>
      <div style="font-size:12px;color:var(--text-2);margin-bottom:14px;font-weight:600">{{ $acc->account_name }}</div>
      <div style="font-size:24px;font-weight:900;color:var(--text);letter-spacing:-.6px;margin-bottom:4px">
        {{ $acc->currency === 'IDR' ? 'Rp '.number_format($acc->current_balance,0,',','.') : $acc->currency.' '.number_format($acc->current_balance,2) }}
      </div>
      <div style="font-family:monospace;font-size:11.5px;color:var(--text-3);letter-spacing:.05em">{{ $acc->account_number }}</div>
    </div>
    <form action="{{ route('admin.finance.bank.accounts.destroy',$acc) }}" method="POST" style="position:absolute;top:16px;right:16px" onsubmit="return confirm('Hapus rekening {{ $acc->bank_name }} - {{ $acc->account_name }}?\n\nRekening akan dinonaktifkan.')">
      @csrf @method('DELETE')
      <button type="submit" style="background:var(--bg2);border:1px solid var(--border);border-radius:8px;padding:5px 10px;font-size:11px;font-weight:700;color:var(--text-3);cursor:pointer;transition:all .2s" onmouseover="this.style.background='#fee2e2';this.style.color='#ef4444';this.style.borderColor='#fecaca'" onmouseout="this.style.background='var(--bg2)';this.style.color='var(--text-3)';this.style.borderColor='var(--border)'">✕</button>
    </form>
  </div>
  @endforeach
</div>
@else
<div class="alert alert-warn mb-24">
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
  <span>Belum ada rekening bank / kas. Klik <strong>Tambah Rekening</strong> untuk memulai pencatatan saldo.</span>
</div>
@endif

{{-- Mutation History --}}
<div class="card">
  <div class="card-hd">
    <div>
      <div class="card-title">Riwayat Mutasi</div>
      <div class="card-sub">Semua transaksi masuk &amp; keluar per rekening (50 terbaru)</div>
    </div>
  </div>
  <div style="overflow-x:auto">
    <table class="tbl">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Keterangan</th>
          <th>Rekening</th>
          <th class="tbl-right">Masuk (+)</th>
          <th class="tbl-right">Keluar (−)</th>
          <th class="tbl-right">Saldo Setelah</th>
          <th class="tbl-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($mutations as $m)
      <tr>
        <td class="muted nowrap">{{ $m->date?->format('d M Y') }}</td>
        <td>
          <div class="semibold" style="color:var(--text)">{{ $m->description }}</div>
          @if($m->reference_number)<div class="smaller muted mono">{{ $m->reference_number }}</div>@endif
        </td>
        <td>
          <div class="semibold" style="font-size:12px;color:var(--text)">{{ $m->account?->bank_name }}</div>
          <div class="smaller muted">{{ $m->account?->account_name }}</div>
        </td>
        <td class="tbl-right" style="font-weight:700;color:#34d399">
          @if($m->mutation_type === 'in')
            + Rp {{ number_format($m->credit,0,',','.') }}
          @else
            <span style="color:var(--text-3)">—</span>
          @endif
        </td>
        <td class="tbl-right" style="font-weight:700;color:#f87171">
          @if($m->mutation_type === 'out')
            − Rp {{ number_format($m->debit,0,',','.') }}
          @else
            <span style="color:var(--text-3)">—</span>
          @endif
        </td>
        <td class="tbl-right muted" style="font-size:12px">
          Rp {{ number_format($m->balance_after,0,',','.') }}
        </td>
        <td class="tbl-center">
          <form action="{{ route('admin.finance.bank.mutations.destroy',$m) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus mutasi ini?\n\nSaldo rekening akan dikembalikan.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="7">
        <div class="empty-state">
          <div class="empty-state-ico">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
          </div>
          <p>Belum ada mutasi tercatat</p>
          <button onclick="openM('mMutation')" class="btn btn-outline btn-sm">Catat Mutasi Pertama</button>
        </div>
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Add Account Modal --}}
<div id="mAccount" class="modal-wrap">
  <div class="modal" style="max-width:440px">
    <div class="modal-hd">
      <div>
        <div class="modal-title">Tambah Rekening</div>
        <div class="modal-subtitle">Bank, tabungan, atau kas tunai</div>
      </div>
      <button class="modal-x" onclick="closeM('mAccount')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form action="{{ route('admin.finance.bank.accounts.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="g2">
          <div class="fi-grp">
            <label class="fl">Nama Bank / Institusi <span class="req">*</span></label>
            <input type="text" name="bank_name" required class="fi" placeholder="BCA, Mandiri, BRI, Kas Tunai…">
          </div>
          <div class="fi-grp">
            <label class="fl">Atas Nama <span class="req">*</span></label>
            <input type="text" name="account_name" required class="fi" placeholder="PT. 153 Kreatif">
          </div>
          <div class="fi-grp gc2">
            <label class="fl">No. Rekening / Referensi <span class="req">*</span></label>
            <input type="text" name="account_number" required class="fi" placeholder="1234567890 (atau 'CASH' untuk kas tunai)">
          </div>
          <div class="fi-grp">
            <label class="fl">Saldo Awal (Rp)</label>
            <input type="number" name="initial_balance" step="1000" min="0" class="fi" placeholder="0">
          </div>
          <div class="fi-grp">
            <label class="fl">Mata Uang</label>
            <select name="currency" class="fi">
              <option value="IDR">🇮🇩 IDR – Rupiah</option>
              <option value="USD">🇺🇸 USD – US Dollar</option>
              <option value="SGD">🇸🇬 SGD – Singapore Dollar</option>
              <option value="EUR">🇪🇺 EUR – Euro</option>
            </select>
          </div>
          <div class="fi-grp gc2">
            <label class="fl">Catatan</label>
            <input type="text" name="notes" class="fi" placeholder="Rekening operasional, dll.">
          </div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closeM('mAccount')" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Tambah Rekening
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Add Mutation Modal --}}
<div id="mMutation" class="modal-wrap">
  <div class="modal" style="max-width:460px">
    <div class="modal-hd">
      <div>
        <div class="modal-title">Catat Mutasi</div>
        <div class="modal-subtitle">Transaksi masuk (+) atau keluar (−) pada rekening</div>
      </div>
      <button class="modal-x" onclick="closeM('mMutation')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form action="{{ route('admin.finance.bank.mutations.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="info-box mb-16" style="font-size:11.5px">
          <strong>Masuk (Kredit):</strong> uang masuk ke rekening, misal transfer dari klien.<br>
          <strong>Keluar (Debit):</strong> uang keluar dari rekening, misal pembayaran vendor.
        </div>
        <div class="g2">
          <div class="fi-grp gc2">
            <label class="fl">Rekening <span class="req">*</span></label>
            <select name="bank_account_id" required class="fi">
              <option value="">Pilih rekening…</option>
              @foreach($accounts as $acc)
              <option value="{{ $acc->id }}">
                {{ $acc->bank_name }} – {{ $acc->account_name }}
                (Rp {{ number_format($acc->current_balance,0,',','.') }})
              </option>
              @endforeach
            </select>
          </div>
          <div class="fi-grp">
            <label class="fl">Jenis Transaksi <span class="req">*</span></label>
            <select name="mutation_type" required class="fi" onchange="updateMutationColor(this.value)">
              <option value="in">⬆ Masuk (Kredit)</option>
              <option value="out">⬇ Keluar (Debit)</option>
            </select>
          </div>
          <div class="fi-grp">
            <label class="fl">Jumlah (Rp) <span class="req">*</span></label>
            <input type="number" name="amount" step="1000" min="1" required class="fi" placeholder="0" id="mut-amount">
          </div>
          <div class="fi-grp gc2">
            <label class="fl">Keterangan <span class="req">*</span></label>
            <input type="text" name="description" required class="fi" placeholder="Misal: Transfer dari PT. ABC untuk event Annual Gathering">
          </div>
          <div class="fi-grp">
            <label class="fl">Tanggal <span class="req">*</span></label>
            <input type="date" name="date" value="{{ now()->toDateString() }}" required class="fi">
          </div>
          <div class="fi-grp">
            <label class="fl">No. Referensi / Bukti</label>
            <input type="text" name="reference_number" class="fi" placeholder="No. bukti transfer, ref. VA…">
          </div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" onclick="closeM('mMutation')" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-primary">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Catat Mutasi
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

function updateMutationColor(type) {
  const amtInput = document.getElementById('mut-amount');
  amtInput.style.color = type === 'in' ? '#34d399' : '#f87171';
}
</script>
@endpush
