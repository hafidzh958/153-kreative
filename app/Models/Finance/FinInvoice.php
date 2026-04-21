<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class FinInvoice extends Model
{
    use HasFactory;

    protected $table = 'fin_invoices';

    protected $fillable = [
        'invoice_number', 'client_name', 'client_email', 'client_phone',
        'product_type', 'client_address', 'client_pic',
        'event_name', 'event_date_start', 'event_date_end', 'venue', 'space',
        'date', 'due_date', 'subtotal', 'tax_rate', 'is_non_tax',
        'tax_amount', 'total', 'paid_amount', 'status', 'notes',
        'bank_account', 'ref_quotation',
    ];

    protected $casts = [
        'date'       => 'date',
        'due_date'   => 'date',
        'subtotal'   => 'decimal:2',
        'tax_rate'   => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total'      => 'decimal:2',
        'paid_amount'=> 'decimal:2',
    ];

    // Auto-calculate remaining balance
    public function getRemainingAttribute(): float
    {
        return (float) $this->total - (float) $this->paid_amount;
    }

    // Status label in Indonesian
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'   => 'Draft',
            'sent'    => 'Dikirim',
            'paid'    => 'Lunas',
            'overdue' => 'Overdue',
            'partial' => 'Sebagian',
            default   => ucfirst($this->status),
        };
    }

    // Auto-check overdue on save
    protected static function booted(): void
    {
        static::saving(function (FinInvoice $inv) {
            if ($inv->status === 'sent' && $inv->due_date && $inv->due_date->isPast()) {
                $inv->status = 'overdue';
            }
            if ((float) $inv->paid_amount >= (float) $inv->total && $inv->total > 0) {
                $inv->status = 'paid';
            } elseif ((float) $inv->paid_amount > 0 && (float) $inv->paid_amount < (float) $inv->total) {
                $inv->status = 'partial';
            }
        });

        // Keep sidebar badge count fresh
        static::saved(fn () => Cache::forget('fin_sidebar_overdue'));
        static::deleted(fn () => Cache::forget('fin_sidebar_overdue'));
    }

    public static function generateNumber(): string
    {
        $prefix = \DB::table('fin_settings')->where('key', 'invoice_prefix')->value('value') ?? 'INV';
        $year   = now()->format('Y');
        $month  = now()->format('m');
        $next   = (int) (\DB::table('fin_settings')->where('key', 'invoice_next_number')->value('value') ?? 1);
        \DB::table('fin_settings')->where('key', 'invoice_next_number')->update(['value' => $next + 1]);
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $next);
    }
}
