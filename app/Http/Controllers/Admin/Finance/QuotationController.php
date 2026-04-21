<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinQuotation;
use App\Models\Finance\FinInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = FinQuotation::latest();
        if ($request->status && $request->status !== 'all') $query->where('status', $request->status);
        if ($request->search) { $q = $request->search; $query->where(fn($b) => $b->where('quotation_number','like',"%$q%")->orWhere('client_name','like',"%$q%")->orWhere('event_name','like',"%$q%")); }
        $quotations = $query->paginate(15)->withQueryString();
        $stats = ['all'=>FinQuotation::count(),'draft'=>FinQuotation::where('status','draft')->count(),'sent'=>FinQuotation::where('status','sent')->count(),'approved'=>FinQuotation::where('status','approved')->count(),'converted'=>FinQuotation::where('status','converted')->count(),'rejected'=>FinQuotation::where('status','rejected')->count()];
        $taxRate = (float)(DB::table('fin_settings')->where('key','default_tax_rate')->value('value') ?? 11);
        return view('admin.finance.quotations.index', compact('quotations','stats','taxRate'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name'  => 'required|string',
            'client_email' => 'nullable|email',
            'client_phone' => 'nullable|string',
            'event_name'   => 'nullable|string',
            'package_type' => 'nullable|string',
            'subtotal'     => 'required|numeric|min:0',
            'tax_rate'     => 'required|numeric',
            'valid_until'  => 'required|date',
            'notes'        => 'nullable|string',
        ]);
        $data['quotation_number'] = FinQuotation::generateNumber();
        $data['date']             = now()->toDateString();
        $data['status']           = 'draft';
        $data['tax_amount']       = round(($data['subtotal'] * $data['tax_rate']) / 100, 2);
        $data['total']            = $data['subtotal'] + $data['tax_amount'];
        FinQuotation::create($data);
        return redirect()->route('admin.finance.quotations.index')->with('success', "Quotation {$data['quotation_number']} berhasil dibuat.");
    }

    public function update(Request $request, FinQuotation $quotation)
    {
        $data = $request->validate([
            'client_name'  => 'required|string',
            'event_name'   => 'nullable|string',
            'package_type' => 'nullable|string',
            'subtotal'     => 'required|numeric|min:0',
            'tax_rate'     => 'required|numeric|min:0',
            'valid_until'  => 'nullable|date',
            'status'       => 'required|in:draft,sent,approved,rejected',
            'notes'        => 'nullable|string',
        ]);
        $data['tax_amount'] = round(($data['subtotal'] * $data['tax_rate']) / 100, 2);
        $data['total']      = $data['subtotal'] + $data['tax_amount'];
        $quotation->update($data);
        return redirect()->route('admin.finance.quotations.index')
            ->with('success', "Status Quotation {$quotation->quotation_number} diperbarui menjadi '{$data['status']}'.");
    }

    public function updateStatus(Request $request, FinQuotation $quotation)
    {
        $data = $request->validate([
            'status' => 'required|in:draft,sent,approved,rejected',
        ]);
        $quotation->update($data);
        return redirect()->route('admin.finance.quotations.index')
            ->with('success', "Status Quotation {$quotation->quotation_number} diperbarui menjadi '{$data['status']}'.");
    }

    public function convert(FinQuotation $quotation)
    {
        if ($quotation->status === 'converted') return back()->with('error', 'Quotation sudah dikonversi sebelumnya.');
        $termDays = (int)(DB::table('fin_settings')->where('key','default_payment_term')->value('value') ?? 30);
        $inv = FinInvoice::create([
            'invoice_number' => FinInvoice::generateNumber(),
            'client_name'    => $quotation->client_name,
            'client_email'   => $quotation->client_email,
            'client_phone'   => $quotation->client_phone,
            'event_name'     => $quotation->event_name,
            'date'           => now()->toDateString(),
            'due_date'       => now()->addDays($termDays)->toDateString(),
            'subtotal'       => $quotation->subtotal,
            'tax_rate'       => $quotation->tax_rate,
            'tax_amount'     => $quotation->tax_amount,
            'total'          => $quotation->total,
            'paid_amount'    => 0,
            'status'         => 'draft',
            'notes'          => "Dikonversi dari {$quotation->quotation_number}",
        ]);
        $quotation->update(['status' => 'converted', 'invoice_id' => $inv->id]);
        return redirect()->route('admin.finance.invoices.index')->with('success', "Quotation dikonversi ke Invoice {$inv->invoice_number}.");
    }

    public function destroy(FinQuotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('admin.finance.quotations.index')->with('success', 'Quotation dihapus.');
    }

    public function pdf(FinQuotation $quotation)
    {
        // Setup dompdf to view the file
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.finance.quotations.pdf', compact('quotation'));
        return $pdf->stream("Quotation_{$quotation->quotation_number}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $query = FinQuotation::latest();
        if ($request->status && $request->status !== 'all') $query->where('status', $request->status);
        $quotations = $query->get();

        $statusLabels = ['draft'=>'Draft','sent'=>'Dikirim','approved'=>'Disetujui','converted'=>'Dikonversi','rejected'=>'Ditolak'];

        $filename = 'quotation_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($quotations, $statusLabels) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ['No. Quotation','Klien','Email Klien','Event','Tanggal','Berlaku Hingga','Subtotal (Rp)','PPN %','PPN (Rp)','Total (Rp)','Status']);
            foreach ($quotations as $q) {
                fputcsv($out, [
                    $q->quotation_number,
                    $q->client_name,
                    $q->client_email ?? '',
                    $q->event_name ?? '',
                    $q->date?->format('d/m/Y'),
                    $q->valid_until?->format('d/m/Y'),
                    $q->subtotal,
                    $q->tax_rate,
                    $q->tax_amount,
                    $q->total,
                    $statusLabels[$q->status] ?? $q->status,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
