<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinPurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = FinPurchaseOrder::latest();
        if ($request->status && $request->status !== 'all') $query->where('status', $request->status);
        if ($request->category && $request->category !== 'all') $query->where('category', $request->category);
        if ($request->search) { $q = $request->search; $query->where(fn($b) => $b->where('po_number','like',"%$q%")->orWhere('vendor_name','like',"%$q%")->orWhere('event_name','like',"%$q%")); }
        $pos     = $query->paginate(15)->withQueryString();
        $pending = FinPurchaseOrder::where('status','pending')->get();
        $stats   = ['all'=>FinPurchaseOrder::count(),'pending'=>FinPurchaseOrder::where('status','pending')->count(),'approved'=>FinPurchaseOrder::where('status','approved')->count(),'paid'=>FinPurchaseOrder::where('status','paid')->count(),'rejected'=>FinPurchaseOrder::where('status','rejected')->count()];
        return view('admin.finance.purchase-orders.index', compact('pos','pending','stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['vendor_name'=>'required|string','vendor_contact'=>'nullable|string','vendor_email'=>'nullable|email','category'=>'required','event_name'=>'nullable|string','description'=>'nullable|string','amount'=>'required|numeric|min:0','date'=>'required|date','delivery_date'=>'nullable|date','notes'=>'nullable|string']);
        $data['po_number']   = FinPurchaseOrder::generateNumber();
        $data['status']      = 'pending';
        $data['paid_amount'] = 0;
        FinPurchaseOrder::create($data);
        return redirect()->route('admin.finance.purchase-orders.index')->with('success', "PO {$data['po_number']} dibuat, menunggu persetujuan.");
    }

    public function approve(FinPurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update(['status' => 'approved']);
        return back()->with('success', "PO {$purchaseOrder->po_number} disetujui.");
    }

    public function reject(FinPurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update(['status' => 'rejected']);
        return back()->with('success', "PO {$purchaseOrder->po_number} ditolak.");
    }

    public function updatePayment(Request $request, FinPurchaseOrder $purchaseOrder)
    {
        $data = $request->validate(['paid_amount' => 'required|numeric|min:0']);
        $status = ((float)$data['paid_amount'] >= (float)$purchaseOrder->amount) ? 'paid' : 'partial';
        $purchaseOrder->update(['paid_amount' => $data['paid_amount'], 'status' => $status]);
        return back()->with('success', 'Pembayaran PO diperbarui.');
    }

    public function update(Request $request, FinPurchaseOrder $purchaseOrder)
    {
        $data = $request->validate(['vendor_name'=>'required|string','vendor_contact'=>'nullable|string','vendor_email'=>'nullable|email','category'=>'required','event_name'=>'nullable|string','description'=>'nullable|string','amount'=>'required|numeric','date'=>'required|date','delivery_date'=>'nullable|date','status'=>'required','notes'=>'nullable|string']);
        $purchaseOrder->update($data);
        return redirect()->route('admin.finance.purchase-orders.index')->with('success', 'PO diperbarui.');
    }

    public function destroy(FinPurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();
        return redirect()->route('admin.finance.purchase-orders.index')->with('success', 'PO dihapus.');
    }
}
