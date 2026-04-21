<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Quotation {{ $quotation->quotation_number }}</title>
<style>
body { font-family: 'Helvetica', sans-serif; font-size: 13px; color: #333; margin: 0; padding: 20px; line-height: 1.4; }
.header { width: 100%; margin-bottom: 40px; border-bottom: 2px solid #f59e0b; padding-bottom: 20px; }
.logo { max-width: 150px; }
.title { font-size: 28px; font-weight: bold; color: #f59e0b; text-transform: uppercase; text-align: right; margin-top: -40px; }
.info-table { width: 100%; margin-bottom: 30px; }
.info-table td { vertical-align: top; width: 50%; }
h4 { font-size: 14px; margin: 0 0 10px 0; color: #555; text-transform: uppercase; }
.details { margin-bottom: 30px; }
.items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
.items-table th { background: #fdfae6; padding: 12px; text-align: left; font-size: 12px; text-transform: uppercase; border-bottom: 1px solid #ddd; }
.items-table td { padding: 12px; border-bottom: 1px solid #eee; }
.items-table th.right, .items-table td.right { text-align: right; }
.summary-table { width: 50%; margin-left: auto; border-collapse: collapse; }
.summary-table td { padding: 10px 12px; border-bottom: 1px solid #eee; text-align: right; }
.summary-table .bold { font-weight: bold; font-size: 15px; }
.summary-table .total-row { background: #fffcf0; color: #d97706; border-bottom: none; }
.footer { margin-top: 50px; text-align: center; font-size: 11px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
</style>
</head>
<body>

<div class="header">
  @php
    $logoPath = public_path('assets/img/153.png');
    $logoData = base64_encode(file_get_contents($logoPath));
  @endphp
  <img src="data:image/png;base64,{{ $logoData }}" class="logo">
  <div class="title">QUOTATION (PENAWARAN)</div>
</div>

<table class="info-table">
  <tr>
    <td>
      <h4>Ditujukan Kepada:</h4>
      <strong>{{ $quotation->client_name }}</strong><br>
      @if($quotation->client_phone) Telp: {{ $quotation->client_phone }}<br> @endif
      @if($quotation->client_email) Email: {{ $quotation->client_email }}<br> @endif
    </td>
    <td style="text-align: right;">
      <h4>Detail Penawaran:</h4>
      <strong>No. Ref:</strong> {{ $quotation->quotation_number }}<br>
      <strong>Tanggal:</strong> {{ $quotation->date?->format('d F Y') }}<br>
      <strong>Berlaku Sampai:</strong> {{ $quotation->valid_until?->format('d F Y') ?? '-' }}<br>
      @if($quotation->event_name) <strong>Event:</strong> {{ $quotation->event_name }}<br> @endif
      @if($quotation->package_type) <strong>Paket:</strong> {{ $quotation->package_type }} @endif
    </td>
  </tr>
</table>

<table class="items-table">
  <thead>
    <tr>
      <th>Deskripsi Penawaran</th>
      <th class="right">Jumlah (Rp)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Penawaran Jasa / Layanan @if($quotation->package_type) Paket {{ $quotation->package_type }} @endif @if($quotation->event_name) untuk {{ $quotation->event_name }} @endif</td>
      <td class="right">{{ number_format($quotation->subtotal, 0, ',', '.') }}</td>
    </tr>
  </tbody>
</table>

<table class="summary-table">
  <tr>
    <td>Subtotal</td>
    <td class="bold">{{ number_format($quotation->subtotal, 0, ',', '.') }}</td>
  </tr>
  @if($quotation->tax_rate > 0)
  <tr>
    <td>Estimasi Pajak ({{ $quotation->tax_rate }}%)</td>
    <td>{{ number_format($quotation->tax_amount, 0, ',', '.') }}</td>
  </tr>
  @endif
  <tr class="total-row">
    <td class="bold">TOTAL ESTIMASI</td>
    <td class="bold">Rp {{ number_format($quotation->total, 0, ',', '.') }}</td>
  </tr>
</table>

@if($quotation->notes)
<div style="margin-top: 40px; padding: 15px; background: #fffbeb; border-left: 4px solid #f59e0b; font-size: 12px;">
  <strong>Catatan:</strong><br>
  {{ $quotation->notes }}
</div>
@endif

<div class="footer">
  PT 153 Kreatif Techno<br>
  Dokumen penawaran ini sah dan diterbitkan oleh sistem komputer. <br>
  Menyetujui penawaran ini berarti menyetujui syarat & ketentuan yang berlaku.
</div>

</body>
</html>
