<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Finance\FinInvoice;
use App\Models\Finance\FinQuotation;
use App\Models\Finance\FinPurchaseOrder;

class FinanceSidebarComposer
{
    /**
     * Provide sidebar badge counts to the finance layout.
     *
     * Results are cached for 60 seconds to avoid hitting the DB
     * on every single page request inside the finance module.
     */
    public function compose(View $view): void
    {
        $view->with([
            'sidebarOverdueCount'   => Cache::remember('fin_sidebar_overdue', 60, fn () =>
                FinInvoice::where('status', 'overdue')->count()
            ),
            'sidebarQuotationCount' => Cache::remember('fin_sidebar_quotations', 60, fn () =>
                FinQuotation::whereIn('status', ['draft', 'sent'])->count()
            ),
            'sidebarPendingPOCount' => Cache::remember('fin_sidebar_pending_po', 60, fn () =>
                FinPurchaseOrder::where('status', 'pending')->count()
            ),
        ]);
    }
}
