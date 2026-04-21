<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class FinProject extends Model
{
    protected $table = 'fin_projects';
    protected $fillable = ['project_name', 'project_date', 'capital_price', 'selling_price', 'status'];
    protected $casts = ['project_date' => 'date', 'capital_price' => 'decimal:2', 'selling_price' => 'decimal:2'];

    public function getProfitAttribute()
    {
        return $this->selling_price - $this->capital_price;
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'belum_mulai' => 'Belum Mulai',
            'berlangsung' => 'Berlangsung',
            'selesai' => 'Selesai',
            default => 'Unknown',
        };
    }
}
