<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'address',
        'email',
        'whatsapp',
        'whatsapp_message',
        'phone',
        'cta_title',
        'cta_description',
        'map_link',
        'latitude',
        'longitude',
    ];
}
