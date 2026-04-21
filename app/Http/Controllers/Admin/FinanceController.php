<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinInvoice;
use App\Models\Finance\FinQuotation;
use App\Models\Finance\FinPurchaseOrder;
use App\Models\Finance\FinExpense;
use App\Models\Finance\FinBudget;
use App\Models\Finance\FinBankAccount;
use App\Models\Finance\FinCommission;
use App\Models\Finance\FinIncome;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // ── KPI Stats ────────────────────────────────────────
        $period = $request->input('period', 'month');
        
        $revenueQ = FinInvoice::whereIn('status', ['paid','partial']);
        $incomeQ  = FinIncome::query();
        $expenseQ = FinExpense::query();

        if ($period !== 'all') {
            switch ($period) {
                case 'day':
                    $start = Carbon::today(); $end = Carbon::today()->endOfDay(); break;
                case 'week':
                    $start = Carbon::now()->startOfWeek(); $end = Carbon::now()->endOfWeek(); break;
                case 'month':
                    $start = Carbon::now()->startOfMonth(); $end = Carbon::now()->endOfMonth(); break;
                case '6months':
                    $start = Carbon::now()->subMonths(6)->startOfMonth(); $end = Carbon::now()->endOfMonth(); break;
                case 'year':
                    $start = Carbon::now()->startOfYear(); $end = Carbon::now()->endOfYear(); break;
                default:
                    $start = Carbon::now()->startOfMonth(); $end = Carbon::now()->endOfMonth(); break;
            }
            $revenueQ->whereBetween('date', [$start, $end]);
            $incomeQ->whereBetween('date', [$start, $end]);
            $expenseQ->whereBetween('date', [$start, $end]);
        }

        $invRevenue    = $revenueQ->sum('paid_amount');
        $otherIncome   = $incomeQ->sum('amount');
        
        $totalRevenue  = $invRevenue + $otherIncome;
        $totalExpenses = $expenseQ->sum('amount');
        $netProfit     = $totalRevenue - $totalExpenses;
        
        $outstandingAmount = FinInvoice::whereIn('status', ['sent','overdue','partial'])->sum(\DB::raw('total - paid_amount'));
        $outstandingCount  = FinInvoice::whereIn('status', ['sent','overdue','partial'])->count();
        $overdueInvoices   = FinInvoice::where('status', 'overdue')->get();
        $activeQuotations  = FinQuotation::whereIn('status', ['draft','sent','approved'])->count();
        $pendingApprovals  = FinPurchaseOrder::where('status', 'pending')->count();

        // ── Chart: Last 6 months revenue vs expenses ─────────
        $chartMonths   = [];
        $chartRevenue  = [];
        $chartExpenses = [];

        for ($i = 5; $i >= 0; $i--) {
            $d   = now()->subMonths($i);
            $chartMonths[]   = $d->format('M');
            $chartRevenue[]  = FinInvoice::whereIn('status', ['paid','partial'])->whereYear('date', $d->year)->whereMonth('date', $d->month)->sum('paid_amount');
            $chartExpenses[] = FinExpense::whereYear('date', $d->year)->whereMonth('date', $d->month)->sum('amount');
        }

        // ── Recent invoices ──────────────────────────────────
        $recentInvoices = FinInvoice::latest()->take(5)->get();

        // ── Recent activity (invoices + POs combined) ────────
        $recentActivity = FinInvoice::latest()->take(10)->get();

        // ── Bank accounts ────────────────────────────────────
        $bankAccounts = FinBankAccount::where('is_active', true)->get();

        return view('admin.finance.index', compact(
            'totalRevenue', 'totalExpenses', 'netProfit',
            'outstandingAmount', 'outstandingCount',
            'overdueInvoices', 'activeQuotations', 'pendingApprovals',
            'chartMonths', 'chartRevenue', 'chartExpenses',
            'recentInvoices', 'bankAccounts'
        ));
    }

    public function apiStats(Request $request)
    {
        // JSON endpoint for chart data refresh
        $period = $request->input('period', 'monthly');
        $months = [];
        $revenue = [];
        $expenses = [];

        $count = $period === 'yearly' ? 12 : 6;
        for ($i = $count - 1; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $months[]   = $d->format('M Y');
            $revenue[]  = (float) FinInvoice::whereIn('status', ['paid','partial'])->whereYear('date', $d->year)->whereMonth('date', $d->month)->sum('paid_amount');
            $expenses[] = (float) FinExpense::whereYear('date', $d->year)->whereMonth('date', $d->month)->sum('amount');
        }

        return response()->json(compact('months', 'revenue', 'expenses'));
    }
}
