<?php namespace App\Models\Finance;
use Illuminate\Database\Eloquent\Model;
class FinBudget extends Model {
    protected $table = 'fin_budgets';
    protected $fillable = ['event_name','client_name','total_budget','venue_budget','fb_budget','talent_budget','transport_budget','marketing_budget','other_budget','start_date','end_date','status','notes'];
    protected $casts = ['start_date'=>'date','end_date'=>'date','total_budget'=>'decimal:2','venue_budget'=>'decimal:2','fb_budget'=>'decimal:2','talent_budget'=>'decimal:2','transport_budget'=>'decimal:2','marketing_budget'=>'decimal:2','other_budget'=>'decimal:2'];
    public function getActualSpendingAttribute(): float {
        return (float) FinExpense::where('event_name', $this->event_name)->sum('amount');
    }
    public function getUsedPercentAttribute(): float {
        if ($this->total_budget <= 0) return 0;
        return min(100, round(($this->actual_spending / $this->total_budget) * 100, 1));
    }
}
