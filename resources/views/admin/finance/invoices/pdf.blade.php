<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Invoice {{ $invoice->invoice_number }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "MS PMincho", "Times New Roman", serif;
      font-size: 11pt;
      color: #000;
      background: #fff;
      padding: 0 28pt 28pt 28pt;
      line-height: 1.4;
    }

    /* HEADER IMAGE */
    .header-img {
      width: 100%;
      display: block;
    }

    /* TITLE */
    .inv-title {
      text-align: center;
      font-size: 13pt;
      font-weight: bold;
      text-decoration: underline;
      margin: 18pt 0 4pt;
      font-family: Arial, sans-serif;
    }

    .inv-no {
      text-align: center;
      font-size: 11pt;
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 14pt;
      font-family: Arial, sans-serif;
    }

    /* CLIENT TABLE */
    .client-tbl {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10pt;
    }

    .client-tbl td {
      padding: 2pt 0;
      font-size: 11pt;
      vertical-align: top;
    }

    .cl {
      width: 155pt;
    }

    .cs {
      width: 14pt;
    }

    .cv {}

    /* REF PARAGRAPH */
    .ref-para {
      font-size: 11pt;
      margin-bottom: 8pt;
      line-height: 1.65;
      text-align: justify;
      text-indent: 0;
    }

    /* EVENT TABLE */
    .event-outer {
      width: 100%;
      margin-bottom: 6pt;
    }

    .event-tbl {
      width: 70%;
      margin: 0 auto;
      border-collapse: collapse;
    }

    .event-tbl td {
      padding: 3pt 4pt;
      font-size: 11pt;
      vertical-align: top;
    }

    .el {
      width: 60pt;
    }

    .es {
      width: 14pt;
    }

    .ev {
      font-weight: bold;
    }

    /* PRICE */
    .price-cell {
      color: #8B0000;
      font-size: 13pt;
      font-weight: bold;
    }

    .non-tax {
      color: #8B0000;
      font-weight: bold;
      font-size: 11pt;
      margin-left: 12pt;
    }

    /* TERBILANG */
    .terbilang {
      text-align: center;
      font-style: italic;
      font-weight: bold;
      font-size: 10.5pt;
      margin-bottom: 12pt;
    }

    /* ATTENTION */
    .attn-wrap {
      margin-bottom: 8pt;
      font-size: 11pt;
    }

    .attn-title {
      font-weight: bold;
      text-decoration: underline;
    }

    .attn-sub {
      font-weight: bold;
      text-decoration: underline;
    }

    /* BANK TABLE */
    .bank-tbl {
      width: 56%;
      border-collapse: collapse;
      margin: 4pt 0 8pt 14pt;
    }

    .bank-tbl td {
      padding: 2pt 0;
      font-size: 11pt;
      vertical-align: top;
    }

    .bl {
      width: 90pt;
    }

    .bs {
      width: 14pt;
    }

    .bv {}

    /* CLOSING */
    .closing {
      font-size: 11pt;
      margin-bottom: 6pt;
      line-height: 1.65;
      text-align: justify;
      text-indent: 28pt;
    }

    /* SIGNATURE */
    .sign-wrap {
      margin-top: 18pt;
      width: 100%;
    }

    .sign-city {
      text-align: center;
      font-size: 11pt;
      margin-bottom: 14pt;
    }

    .sign-tbl {
      width: 100%;
      border-collapse: collapse;
    }

    .sign-tbl td {
      width: 50%;
      text-align: center;
      vertical-align: top;
      font-size: 11pt;
    }

    .sign-co {
      font-weight: bold;
      margin-bottom: 52pt;
    }

    .sign-name {
      font-weight: bold;
    }

    /* NOTE */
    .note-box {
      margin: 8pt 0;
      padding: 6pt 10pt;
      background: #fff8f0;
      border-left: 3pt solid #e67e22;
      font-size: 10pt;
    }

    /* SEPARATOR */
    .sep-line {
      border: none;
      border-top: 1.5pt solid #333;
      margin: 10pt 0 4pt;
    }
  </style>
</head>

<body>

  @php
    $headerPath = public_path('assets/img/inv_header.png');
    $headerData = base64_encode(file_get_contents($headerPath));
    $terbilang = \App\Helpers\Terbilang::rupiah($invoice->total);

    /* Bank info — 3 baris */
    $bankLines = preg_split('/\r?\n/', trim($invoice->bank_account ?? ''));
    $bankLines = array_values(array_filter(array_map('trim', $bankLines)));
    $bankName = $bankLines[0] ?? 'Bank BCA';
    $bankNoRek = $bankLines[1] ?? '-';
    $bankAtas = $bankLines[2] ?? 'Satu Lima Tiga PT';

    /* Event dates */
    $evStart = $invoice->event_date_start ?? '';
    $evEnd = $invoice->event_date_end ?? '';
    $evDate = trim($evStart . ($evEnd ? ' – ' . $evEnd : ''));
    if (!$evDate)
      $evDate = optional($invoice->date)->format('d F Y');

    /* Tanggal surat */
    $bulanId = [
      '',
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    ];
    $tglSurat = optional($invoice->date)->format('j') . ' ' .
      ($bulanId[(int) optional($invoice->date)->format('n')] ?? '') . ' ' .
      optional($invoice->date)->format('Y');
  @endphp

  {{-- ══ HEADER IMAGE ══ --}}
  <img src="data:image/png;base64,{{ $headerData }}" class="header-img" alt="PT 153 KREATIF">

  {{-- ══ TITLE ══ --}}
  <div class="inv-title">Invoice Of Claim</div>
  <div class="inv-no">No :{{ $invoice->invoice_number }}</div>

  {{-- ══ CLIENT INFO ══ --}}
  <table class="client-tbl">
    <tr>
      <td class="cl">Nama Perusahaan</td>
      <td class="cs">:</td>
      <td class="cv">{{ $invoice->client_name }}</td>
    </tr>
    @if($invoice->product_type)
      <tr>
        <td class="cl">Jenis/ Merk Product</td>
        <td class="cs">:</td>
        <td class="cv">{{ $invoice->product_type }}</td>
      </tr>
    @endif
    @if($invoice->client_address)
      <tr>
        <td class="cl">Alamat lengkap kantor</td>
        <td class="cs">:</td>
        <td class="cv">{{ $invoice->client_address }}</td>
      </tr>
    @endif
    @if($invoice->client_pic)
      <tr>
        <td class="cl">Penanggungjawab</td>
        <td class="cs">:</td>
        <td class="cv">{{ $invoice->client_pic }}</td>
      </tr>
    @endif
  </table>

  {{-- ══ REF PARAGRAPH ══ --}}
  @if($invoice->ref_quotation || $invoice->event_name)
    <div class="ref-para">
      Berdasarkan Surat
      Penawaran{!! $invoice->ref_quotation ? ' No <strong>' . e($invoice->ref_quotation) . '</strong>,' : '' !!}
      menyatakan keikutsertaan sebagai <em>tenant</em> dalam
      pameran yang diselenggarakan oleh <strong>PT 153 Kreatif</strong>, pada,
    </div>
  @endif

  {{-- ══ EVENT DETAIL TABLE ══ --}}
  <div class="event-outer">
    <table class="event-tbl">
      @if($invoice->event_name)
        <tr>
          <td class="el">Event</td>
          <td class="es">:</td>
          <td class="ev">{{ $invoice->event_name }}</td>
        </tr>
      @endif
      <tr>
        <td class="el">Date</td>
        <td class="es">:</td>
        <td class="ev">{{ $evDate }}</td>
      </tr>
      @if($invoice->venue)
        <tr>
          <td class="el">Venue</td>
          <td class="es">:</td>
          <td class="ev">{{ $invoice->venue }}</td>
        </tr>
      @endif
      @if($invoice->space)
        <tr>
          <td class="el">Space</td>
          <td class="es">:</td>
          <td class="ev">{{ $invoice->space }}</td>
        </tr>
      @endif
      <tr>
        <td class="el">Price</td>
        <td class="es">:</td>
        <td>
          <span class="price-cell">Rp.{{ number_format($invoice->total, 0, ',', '.') }},-</span>
          @if($invoice->is_non_tax)
            <span class="non-tax">( NON TAX )</span>
          @elseif($invoice->tax_rate > 0)
            <span style="font-size:9pt;color:#555;margin-left:8pt">Termasuk PPN
              {{ number_format($invoice->tax_rate, 0) }}%</span>
          @endif
        </td>
      </tr>
    </table>
  </div>

  <div class="terbilang">{{ $terbilang }}</div>

  {{-- ══ PAYMENT INFO ══ --}}
  <div class="attn-wrap">
    <span class="attn-title">ATTENTION:</span><br>
    <span class="attn-sub">Seluruh PEMBAYARAN,harap DITRANSFER LUNAS melalui rekening berikut :</span>
  </div>
  <table class="bank-tbl">
    <tr>
      <td class="bl">Nama Bank</td>
      <td class="bs">:</td>
      <td class="bv">{{ $bankName }}</td>
    </tr>
    <tr>
      <td class="bl">No. Rekening</td>
      <td class="bs">:</td>
      <td class="bv">{{ $bankNoRek }}</td>
    </tr>
    <tr>
      <td class="bl">Atas Nama</td>
      <td class="bs">:</td>
      <td class="bv">{{ $bankAtas }}</td>
    </tr>
  </table>

  <div class="closing">
    Bukti Transfer Asli diserahkan ke Pihak 153 <strong>KREATIF</strong>, Konfirmasi Pembayaran agar menghubungi Telepon
    : <strong>082125011963</strong>.
  </div>
  <div class="closing">
    Dengan demikian 153 KREATIF TIDAK BERTANGGUNG JAWAB jika pembayaran dilakukan di luar prosedur tersebut, dan seluruh
    pembayaran akan dianggap SAH jika 153 Organizer telah menerbitkan <strong>KWITANSI RESMI</strong>.
  </div>

  @if($invoice->notes)
    <div class="note-box"><strong>Catatan:</strong> {{ $invoice->notes }}</div>
  @endif

  {{-- ══ SIGNATURE ══ --}}
  <div class="sign-wrap">
    <div class="sign-city">Cirebon, {{ $tglSurat }}</div>
    <table class="sign-tbl">
      <tr>
        <td>
          <div class="sign-co">PT.153 Kreatif</div>
        </td>
        <td>
          <div class="sign-co">{{ $invoice->client_name }}</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="sign-name">Mahfud Jafar</div>
        </td>
        <td>
          <div class="sign-name">{{ $invoice->client_pic ?: '&nbsp;' }}</div>
        </td>
      </tr>
    </table>
  </div>

</body>

</html>