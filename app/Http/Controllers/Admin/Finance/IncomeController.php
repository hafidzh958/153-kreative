<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinIncome;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = FinIncome::latest('date');

        if ($request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        if ($request->search) {
            $q = $request->search;
            $query->where(fn($b) => $b
                ->where('description', 'like', "%$q%")
                ->orWhere('source', 'like', "%$q%")
                ->orWhere('event_name', 'like', "%$q%")
                ->orWhere('reference', 'like', "%$q%")
            );
        }
        if ($request->month) {
            $query->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$request->month]);
        }

        $incomes = $query->paginate(20)->withQueryString();

        // Stats
        $totalThisMonth  = FinIncome::whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount');
        $totalThisYear   = FinIncome::whereYear('date', now()->year)->sum('amount');
        $totalAll        = FinIncome::sum('amount');
        $countThisMonth  = FinIncome::whereYear('date', now()->year)->whereMonth('date', now()->month)->count();

        // Category totals for this month
        $catTotals = FinIncome::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('admin.finance.incomes.index', compact(
            'incomes', 'totalThisMonth', 'totalThisYear', 'totalAll', 'countThisMonth', 'catTotals'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description'    => 'required|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'date'           => 'required|date',
            'category'       => 'required|in:event,dp,retainer,refund,bonus,other',
            'source'         => 'nullable|string|max:255',
            'event_name'     => 'nullable|string|max:255',
            'reference'      => 'nullable|string|max:100',
            'payment_method' => 'required|in:transfer,cash,qris,check',
            'notes'          => 'nullable|string',
        ]);

        FinIncome::create($data);
        return redirect()->route('admin.finance.incomes.index')->with('success', 'Pemasukan berhasil dicatat.');
    }

    public function destroy(FinIncome $income)
    {
        $income->delete();
        return back()->with('success', 'Data pemasukan dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $query = FinIncome::latest('date');
        if ($request->category && $request->category !== 'all') $query->where('category', $request->category);
        if ($request->month) { $query->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$request->month]); }
        $incomes = $query->get();

        $catLabels = ['event'=>'Pembayaran Event','dp'=>'Down Payment','retainer'=>'Retainer Fee','refund'=>'Refund','bonus'=>'Bonus','other'=>'Lainnya'];
        $pmLabels  = ['transfer'=>'Transfer Bank','cash'=>'Tunai','qris'=>'QRIS','check'=>'Cek/Giro'];

        $filename = 'pemasukan_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($incomes, $catLabels, $pmLabels) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Tanggal','Deskripsi','Kategori','Sumber/Klien','Nama Event','Metode Bayar','No. Referensi','Jumlah (Rp)','Catatan']);
            foreach ($incomes as $i) {
                fputcsv($out, [
                    $i->date?->format('d/m/Y'),
                    $i->description,
                    $catLabels[$i->category] ?? $i->category,
                    $i->source ?? '',
                    $i->event_name ?? '',
                    $pmLabels[$i->payment_method] ?? $i->payment_method,
                    $i->reference ?? '',
                    $i->amount,
                    $i->notes ?? '',
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
