<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'is_main',
        'order',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'order'   => 'integer',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(ServiceFeature::class);
    }
}