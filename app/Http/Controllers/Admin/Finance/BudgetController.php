<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinBudget;
use App\Models\Finance\FinExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = FinBudget::latest()->paginate(15);

        foreach ($budgets as $budget) {
            $actualSpend = (float) FinExpense::where('event_name', $budget->event_name)->sum('amount');
            $usedPct     = $budget->total_budget > 0
                ? round(($actualSpend / $budget->total_budget) * 100, 1)
                : 0;

            // Auto-switch to over_budget — gunakan DB::table agar properti non-kolom
            // (actual, used_pct) tidak ikut tersimpan oleh Eloquent
            if ($usedPct > 100 && $budget->status === 'active') {
                DB::table('fin_budgets')
                    ->where('id', $budget->id)
                    ->update(['status' => 'over_budget', 'updated_at' => now()]);
                $budget->status = 'over_budget';
            }

            // Assign properti sementara untuk view (bukan kolom DB)
            $budget->actual   = $actualSpend;
            $budget->used_pct = $usedPct;
        }

        return view('admin.finance.budgets.index', compact('budgets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['event_name'=>'required|string','client_name'=>'nullable|string','total_budget'=>'required|numeric|min:0','venue_budget'=>'nullable|numeric|min:0','fb_budget'=>'nullable|numeric|min:0','talent_budget'=>'nullable|numeric|min:0','transport_budget'=>'nullable|numeric|min:0','marketing_budget'=>'nullable|numeric|min:0','other_budget'=>'nullable|numeric|min:0','start_date'=>'nullable|date','end_date'=>'nullable|date','notes'=>'nullable|string']);
        $data['status'] = 'active';
        FinBudget::create($data);
        return redirect()->route('admin.finance.budgets.index')->with('success', 'Anggaran berhasil dibuat.');
    }

    public function update(Request $request, FinBudget $budget)
    {
        $data = $request->validate(['event_name'=>'required|string','client_name'=>'nullable|string','total_budget'=>'required|numeric|min:0','venue_budget'=>'nullable|numeric','fb_budget'=>'nullable|numeric','talent_budget'=>'nullable|numeric','transport_budget'=>'nullable|numeric','marketing_budget'=>'nullable|numeric','other_budget'=>'nullable|numeric','start_date'=>'nullable|date','end_date'=>'nullable|date','status'=>'required','notes'=>'nullable|string']);
        $budget->update($data);
        return redirect()->route('admin.finance.budgets.index')->with('success', 'Anggaran diperbarui.');
    }

    public function destroy(FinBudget $budget)
    {
        $budget->delete();
        return redirect()->route('admin.finance.budgets.index')->with('success', 'Anggaran dihapus.');
    }
}
