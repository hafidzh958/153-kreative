<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Auto-mark overdue
        FinInvoice::where('status', 'sent')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        $query = FinInvoice::latest();
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $q = $request->search;
            $query->where(fn($b) => $b->where('invoice_number', 'like', "%$q%")->orWhere('client_name', 'like', "%$q%")->orWhere('event_name', 'like', "%$q%"));
        }

        $invoices = $query->paginate(15)->withQueryString();

        $stats = [
            'all' => FinInvoice::count(),
            'draft' => FinInvoice::where('status', 'draft')->count(),
            'sent' => FinInvoice::where('status', 'sent')->count(),
            'paid' => FinInvoice::where('status', 'paid')->count(),
            'overdue' => FinInvoice::where('status', 'overdue')->count(),
            'partial' => FinInvoice::where('status', 'partial')->count(),
        ];

        return view('admin.finance.invoices.index', compact('invoices', 'stats'));
    }

    public function create()
    {
        $nextNumber = FinInvoice::generateNumber();
        // Rollback — we just peeked
        $current = (int) (DB::table('fin_settings')->where('key', 'invoice_next_number')->value('value') ?? 1);
        DB::table('fin_settings')->where('key', 'invoice_next_number')->update(['value' => $current - 1]);

        $taxRate = (float) (DB::table('fin_settings')->where('key', 'default_tax_rate')->value('value') ?? 11);
        return view('admin.finance.invoices.create', compact('nextNumber', 'taxRate'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email',
            'client_phone' => 'nullable|string',
            'product_type' => 'nullable|string',
            'client_address' => 'nullable|string',
            'client_pic' => 'nullable|string',
            'event_name' => 'nullable|string',
            'event_date_start' => 'nullable|string',
            'event_date_end' => 'nullable|string',
            'venue' => 'nullable|string',
            'space' => 'nullable|string',
            'ref_quotation' => 'nullable|string',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'subtotal' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'is_non_tax' => 'nullable',
            'paid_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,partial',
            'notes' => 'nullable|string',
            'bank_account' => 'nullable|string',
        ]);

        $data['is_non_tax'] = $request->boolean('is_non_tax');
        if ($data['is_non_tax']) {
            $data['tax_rate'] = 0;
            $data['tax_amount'] = 0;
        } else {
            $data['tax_amount'] = round(($data['subtotal'] * $data['tax_rate']) / 100, 2);
        }
        $data['invoice_number'] = FinInvoice::generateNumber();
        $data['total'] = $data['subtotal'] + ($data['tax_amount'] ?? 0);
        $data['paid_amount'] = $data['paid_amount'] ?? 0;

        $inv = FinInvoice::create($data);
        return redirect()->route('admin.finance.invoices.index')->with('success', "Invoice {$inv->invoice_number} berhasil dibuat.");
    }

    public function edit(FinInvoice $invoice)
    {
        return view('admin.finance.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, FinInvoice $invoice)
    {
        $data = $request->validate([
            'client_name' => 'required|string',
            'client_email' => 'nullable|email',
            'client_phone' => 'nullable|string',
            'product_type' => 'nullable|string',
            'client_address' => 'nullable|string',
            'client_pic' => 'nullable|string',
            'event_name' => 'nullable|string',
            'event_date_start' => 'nullable|string',
            'event_date_end' => 'nullable|string',
            'venue' => 'nullable|string',
            'space' => 'nullable|string',
            'ref_quotation' => 'nullable|string',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'is_non_tax' => 'nullable',
            'paid_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,partial',
            'notes' => 'nullable|string',
            'bank_account' => 'nullable|string',
        ]);

        $data['is_non_tax'] = $request->boolean('is_non_tax');
        if ($data['is_non_tax']) {
            $data['tax_rate'] = 0;
            $data['tax_amount'] = 0;
        } else {
            $data['tax_amount'] = round(($data['subtotal'] * $data['tax_rate']) / 100, 2);
        }
        $data['total'] = $data['subtotal'] + ($data['tax_amount'] ?? 0);
        $data['paid_amount'] = $data['paid_amount'] ?? 0;

        $invoice->update($data);
        return redirect()->route('admin.finance.invoices.index')->with('success', "Invoice {$invoice->invoice_number} berhasil diupdate.");
    }

    public function updateStatus(Request $request, FinInvoice $invoice)
    {
        $data = $request->validate(['status' => 'required|in:draft,sent,paid,overdue,partial', 'paid_amount' => 'nullable|numeric|min:0']);
        $invoice->update($data);
        return back()->with('success', 'Status invoice diperbarui.');
    }

    public function destroy(FinInvoice $invoice)
    {
        $number = $invoice->invoice_number;
        $invoice->delete();
        return redirect()->route('admin.finance.invoices.index')->with('success', "Invoice $number dihapus.");
    }

    public function show(FinInvoice $invoice)
    {
        return view('admin.finance.invoices.show', compact('invoice'));
    }

    public function pdf(FinInvoice $invoice)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.finance.invoices.pdf', compact('invoice'));
        return $pdf->stream("Invoice_{$invoice->invoice_number}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $query = FinInvoice::latest();
        if ($request->status && $request->status !== 'all')
            $query->where('status', $request->status);
        if ($request->search) {
            $q = $request->search;
            $query->where(fn($b) => $b->where('invoice_number', 'like', "%$q%")->orWhere('client_name', 'like', "%$q%"));
        }
        $invoices = $query->get();

        $statusLabels = ['draft' => 'Draft', 'sent' => 'Dikirim', 'paid' => 'Lunas', 'overdue' => 'Jatuh Tempo', 'partial' => 'Cicilan'];

        $filename = 'invoice_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($invoices, $statusLabels) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ['No. Invoice', 'Klien', 'Email Klien', 'Event', 'Tanggal', 'Jatuh Tempo', 'Subtotal (Rp)', 'PPN %', 'PPN (Rp)', 'Total (Rp)', 'Sudah Dibayar (Rp)', 'Sisa (Rp)', 'Status']);
            foreach ($invoices as $inv) {
                fputcsv($out, [
                    $inv->invoice_number,
                    $inv->client_name,
                    $inv->client_email ?? '',
                    $inv->event_name ?? '',
                    $inv->date?->format('d/m/Y'),
                    $inv->due_date?->format('d/m/Y'),
                    $inv->subtotal,
                    $inv->tax_rate,
                    $inv->tax_amount,
                    $inv->total,
                    $inv->paid_amount,
                    $inv->total - $inv->paid_amount,
                    $statusLabels[$inv->status] ?? $inv->status,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
