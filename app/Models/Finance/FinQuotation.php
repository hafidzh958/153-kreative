<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class FinQuotation extends Model
{
    protected $table = 'fin_quotations';

    protected $fillable = [
        'quotation_number','client_name','client_email','client_phone',
        'event_name','package_type','subtotal','tax_rate','tax_amount',
        'total','date','valid_until','status','invoice_id','notes',
    ];

    protected $casts = [
        'date'        => 'date',
        'valid_until' => 'date',
        'subtotal'    => 'decimal:2',
        'tax_rate'    => 'decimal:2',
        'tax_amount'  => 'decimal:2',
        'total'       => 'decimal:2',
    ];

    public function invoice() {
        return $this->belongsTo(FinInvoice::class, 'invoice_id');
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'draft'     => 'Draft',
            'sent'      => 'Dikirim',
            'approved'  => 'Disetujui',
            'converted' => 'Dikonversi',
            'rejected'  => 'Ditolak',
            default     => ucfirst($this->status),
        };
    }

    public static function generateNumber(): string {
        $prefix = \DB::table('fin_settings')->where('key', 'quotation_prefix')->value('value') ?? 'QUO';
        $year   = now()->format('Y');
        $month  = now()->format('m');
        $next   = (int)(\DB::table('fin_settings')->where('key', 'quotation_next_number')->value('value') ?? 1);
        \DB::table('fin_settings')->where('key', 'quotation_next_number')->update(['value' => $next + 1]);
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $next);
    }
}
