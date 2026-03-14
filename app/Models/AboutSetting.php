<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'story_title',
        'story_description',
        'story_image',
        'vision_text'
    ];
}
