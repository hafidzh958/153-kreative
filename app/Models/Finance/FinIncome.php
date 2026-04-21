<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class FinIncome extends Model
{
    protected $table = 'fin_incomes';

    protected $fillable = [
        'description', 'amount', 'date', 'category',
        'source', 'event_name', 'reference', 'payment_method', 'notes',
    ];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'decimal:2',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'event'      => 'Pembayaran Event',
            'dp'         => 'Down Payment (DP)',
            'retainer'   => 'Retainer Fee',
            'refund'     => 'Refund / Pengembalian',
            'bonus'      => 'Bonus / Insentif',
            'other'      => 'Lainnya',
            default      => ucfirst($this->category),
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'transfer' => 'Transfer Bank',
            'cash'     => 'Tunai',
            'qris'     => 'QRIS',
            'check'    => 'Cek / Giro',
            default    => ucfirst($this->payment_method),
        };
    }
}
