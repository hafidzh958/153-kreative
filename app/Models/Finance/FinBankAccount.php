<?php namespace App\Models\Finance;
use Illuminate\Database\Eloquent\Model;
class FinBankAccount extends Model {
    protected $table = 'fin_bank_accounts';
    protected $fillable = ['account_name','bank_name','account_number','currency','current_balance','type','is_active','notes'];
    protected $casts = ['current_balance'=>'decimal:2','is_active'=>'boolean'];
    public function mutations() { return $this->hasMany(FinBankMutation::class, 'bank_account_id'); }
    public function getTypeLabel(): string { return match($this->type){'main'=>'Utama','operational'=>'Operasional','foreign'=>'Multi-Currency','savings'=>'Tabungan',default=>ucfirst($this->type)}; }
}
