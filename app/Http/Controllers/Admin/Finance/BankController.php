<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinBankAccount;
use App\Models\Finance\FinBankMutation;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $accounts  = FinBankAccount::where('is_active', true)->get();
        $mutations = FinBankMutation::with('account')->latest('date')->take(50)->get();
        $totalIDR  = FinBankAccount::where('currency','IDR')->where('is_active',true)->sum('current_balance');
        return view('admin.finance.bank.index', compact('accounts','mutations','totalIDR'));
    }

    public function storeAccount(Request $request)
    {
        $data = $request->validate([
            'account_name'    => 'required|string',
            'bank_name'       => 'required|string',
            'account_number'  => 'required|string',
            'currency'        => 'required|in:IDR,USD,SGD,EUR',
            'initial_balance' => 'nullable|numeric|min:0',
            'notes'           => 'nullable|string',
        ]);
        $data['is_active']       = true;
        $data['type']            = 'main';
        $data['current_balance'] = $data['initial_balance'] ?? 0;
        unset($data['initial_balance']);
        FinBankAccount::create($data);
        return redirect()->route('admin.finance.bank.index')->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function storeMutation(Request $request)
    {
        $data = $request->validate(['bank_account_id'=>'required|exists:fin_bank_accounts,id','description'=>'required|string','reference_number'=>'nullable|string','mutation_type'=>'required|in:in,out','amount'=>'required|numeric|min:0.01','date'=>'required|date','notes'=>'nullable|string']);
        $account = FinBankAccount::findOrFail($data['bank_account_id']);
        $amount  = (float) $data['amount'];
        if ($data['mutation_type'] === 'in') {
            $data['credit']       = $amount;
            $data['debit']        = 0;
            $account->increment('current_balance', $amount);
        } else {
            $data['debit']        = $amount;
            $data['credit']       = 0;
            $account->decrement('current_balance', $amount);
        }
        $account->refresh();
        $data['balance_after'] = $account->current_balance;
        unset($data['amount']);
        FinBankMutation::create($data);
        return redirect()->route('admin.finance.bank.index')->with('success', 'Mutasi berhasil dicatat.');
    }

    public function updateAccount(Request $request, FinBankAccount $bankAccount)
    {
        $data = $request->validate(['account_name'=>'required|string','bank_name'=>'required|string','account_number'=>'required|string','type'=>'required','current_balance'=>'required|numeric','is_active'=>'boolean','notes'=>'nullable|string']);
        $data['is_active'] = $request->boolean('is_active', true);
        $bankAccount->update($data);
        return redirect()->route('admin.finance.bank.index')->with('success', 'Rekening diperbarui.');
    }

    public function destroyAccount(FinBankAccount $bankAccount)
    {
        $bankAccount->update(['is_active' => false]);
        return redirect()->route('admin.finance.bank.index')->with('success', 'Rekening dinonaktifkan.');
    }

    public function destroyMutation(FinBankMutation $mutation)
    {
        // Reverse the balance
        $account = $mutation->account;
        if ($mutation->mutation_type === 'in') {
            $account->decrement('current_balance', $mutation->credit);
        } else {
            $account->increment('current_balance', $mutation->debit);
        }
        $mutation->delete();
        return back()->with('success', 'Mutasi dihapus dan saldo dikembalikan.');
    }
}
