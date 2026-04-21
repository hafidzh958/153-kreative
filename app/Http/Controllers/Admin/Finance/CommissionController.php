<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = FinCommission::latest();
        if ($request->status && $request->status !== 'all') $query->where('status', $request->status);
        if ($request->search) { $q = $request->search; $query->where(fn($b) => $b->where('employee_name','like',"%$q%")->orWhere('event_name','like',"%$q%")); }
        $commissions     = $query->paginate(15)->withQueryString();
        $totalThisMonth  = FinCommission::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->sum('commission_amount');
        $totalPaid       = FinCommission::where('status','paid')->sum('commission_amount');
        $totalPending    = FinCommission::whereIn('status',['pending','approved'])->sum('commission_amount');
        $salesRate       = (float)(DB::table('fin_settings')->where('key','commission_sales_rate')->value('value') ?? 5);
        $opsRate         = (float)(DB::table('fin_settings')->where('key','commission_ops_rate')->value('value') ?? 3);
        return view('admin.finance.commissions.index', compact('commissions','totalThisMonth','totalPaid','totalPending','salesRate','opsRate'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_name'     => 'required|string',
            'employee_division' => 'nullable|string',
            'event_name'        => 'nullable|string',
            'revenue_amount'    => 'required|numeric|min:0',
            'rate'              => 'required|numeric|min:0|max:100',
            'type'              => 'required|in:sales,operation,bonus,incentive',
            'notes'             => 'nullable|string',
        ]);
        $data['commission_amount'] = round(($data['revenue_amount'] * $data['rate']) / 100, 2);
        $data['status']            = 'pending';
        FinCommission::create($data);
        return redirect()->route('admin.finance.commissions.index')->with('success', 'Komisi berhasil dicatat.');
    }

    public function approve(FinCommission $commission)
    {
        $commission->update(['status' => 'approved']);
        return back()->with('success', "Komisi {$commission->employee_name} disetujui.");
    }

    public function pay(FinCommission $commission)
    {
        $commission->update(['status' => 'paid', 'paid_at' => now()->toDateString()]);
        return back()->with('success', "Komisi {$commission->employee_name} ditandai sebagai dibayar.");
    }

    public function update(Request $request, FinCommission $commission)
    {
        $data = $request->validate(['employee_name'=>'required|string','employee_division'=>'nullable|string','event_name'=>'nullable|string','revenue_amount'=>'required|numeric','rate'=>'required|numeric','type'=>'required','status'=>'required|in:pending,approved,paid','notes'=>'nullable|string']);
        $data['commission_amount'] = round(($data['revenue_amount'] * $data['rate']) / 100, 2);
        $commission->update($data);
        return redirect()->route('admin.finance.commissions.index')->with('success', 'Komisi diperbarui.');
    }

    public function destroy(FinCommission $commission)
    {
        $commission->delete();
        return redirect()->route('admin.finance.commissions.index')->with('success', 'Komisi dihapus.');
    }
}
