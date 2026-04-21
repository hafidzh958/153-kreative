<?php namespace App\Models\Finance;
use Illuminate\Database\Eloquent\Model;
class FinExpense extends Model {
    protected $table = 'fin_expenses';
    protected $fillable = ['description','category','event_name','amount','date','receipt_path','reimbursable','employee_name','reimbursement_status','notes'];
    protected $casts = ['date'=>'date','amount'=>'decimal:2','reimbursable'=>'boolean'];
    public function getCategoryLabelAttribute(): string { return match($this->category){'venue'=>'Venue','fb'=>'F&B','transport'=>'Transportasi','talent'=>'Talent/AV','marketing'=>'Marketing','admin'=>'Administrasi',default=>'Lainnya'}; }
}
