<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinExpense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = FinExpense::latest('date');
        if ($request->category && $request->category !== 'all') $query->where('category', $request->category);
        if ($request->search) { $q = $request->search; $query->where(fn($b) => $b->where('description','like',"%$q%")->orWhere('event_name','like',"%$q%")->orWhere('employee_name','like',"%$q%")); }
        if ($request->month) { $query->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$request->month]); }
        $expenses  = $query->paginate(15)->withQueryString();
        $catTotals = FinExpense::whereYear('date', now()->year)->whereMonth('date', now()->month)
                      ->selectRaw('category, SUM(amount) as total')->groupBy('category')->pluck('total','category');
        $totalThisMonth = FinExpense::whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount');
        $totalThisYear  = FinExpense::whereYear('date', now()->year)->sum('amount');
        $reimbursements = FinExpense::where('reimbursable', true)->whereIn('reimbursement_status',['pending','approved'])->get();
        return view('admin.finance.expenses.index', compact('expenses','catTotals','totalThisMonth','totalThisYear','reimbursements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['description'=>'required|string','category'=>'required','event_name'=>'nullable|string','amount'=>'required|numeric|min:0','date'=>'required|date','reimbursable'=>'boolean','employee_name'=>'nullable|string','notes'=>'nullable|string']);
        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')->store('finance/receipts','public');
        }
        $data['reimbursable']         = $request->boolean('reimbursable');
        $data['reimbursement_status'] = $data['reimbursable'] ? 'pending' : 'none';
        FinExpense::create($data);
        return redirect()->route('admin.finance.expenses.index')->with('success', 'Pengeluaran dicatat.');
    }

    public function update(Request $request, FinExpense $expense)
    {
        $data = $request->validate(['description'=>'required|string','category'=>'required','event_name'=>'nullable|string','amount'=>'required|numeric','date'=>'required|date','reimbursement_status'=>'nullable|string','notes'=>'nullable|string']);
        $expense->update($data);
        return redirect()->route('admin.finance.expenses.index')->with('success', 'Pengeluaran diperbarui.');
    }

    public function destroy(FinExpense $expense)
    {
        if ($expense->receipt_path) \Storage::disk('public')->delete($expense->receipt_path);
        $expense->delete();
        return redirect()->route('admin.finance.expenses.index')->with('success', 'Pengeluaran dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $query = FinExpense::latest('date');
        if ($request->category && $request->category !== 'all') $query->where('category', $request->category);
        if ($request->month) { $query->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$request->month]); }
        $expenses = $query->get();

        $catLabels = ['venue'=>'Venue','fb'=>'F&B','transport'=>'Transport','talent'=>'Talent','marketing'=>'Marketing','salary'=>'Gaji/HR','other'=>'Lainnya'];

        $filename = 'pengeluaran_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($expenses, $catLabels) {
            $out = fopen('php://output', 'w');
            // BOM for Excel
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Tanggal','Deskripsi','Kategori','Nama Event','Staff/Vendor','Jumlah (Rp)','Catatan']);
            foreach ($expenses as $e) {
                fputcsv($out, [
                    $e->date?->format('d/m/Y'),
                    $e->description,
                    $catLabels[$e->category] ?? $e->category,
                    $e->event_name ?? '',
                    $e->employee_name ?? '',
                    $e->amount,
                    $e->notes ?? '',
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
