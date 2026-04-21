<?php namespace App\Models\Finance;
use Illuminate\Database\Eloquent\Model;
class FinCommission extends Model {
    protected $table = 'fin_commissions';
    protected $fillable = ['employee_name','employee_division','event_name','revenue_amount','rate','commission_amount','type','status','paid_at','notes'];
    protected $casts = ['revenue_amount'=>'decimal:2','rate'=>'decimal:2','commission_amount'=>'decimal:2','paid_at'=>'date'];
    public function getTypeLabel(): string { return match($this->type){'sales'=>'Komisi Sales','operation'=>'Komisi Ops','bonus'=>'Bonus','incentive'=>'Insentif',default=>ucfirst($this->type)}; }
    public function getStatusLabel(): string { return match($this->status){'pending'=>'Proses','approved'=>'Disetujui','paid'=>'Dibayar',default=>ucfirst($this->status)}; }
}
