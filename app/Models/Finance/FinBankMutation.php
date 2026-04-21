<?php namespace App\Models\Finance;
use Illuminate\Database\Eloquent\Model;
class FinBankMutation extends Model {
    protected $table = 'fin_bank_mutations';
    protected $fillable = ['bank_account_id','description','reference_number','debit','credit','balance_after','date','mutation_type','notes'];
    protected $casts = ['date'=>'date','debit'=>'decimal:2','credit'=>'decimal:2','balance_after'=>'decimal:2'];
    public function account() { return $this->belongsTo(FinBankAccount::class, 'bank_account_id'); }
}
