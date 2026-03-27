<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_button_text',
        'hero_button_link',
        'hero_background_image',
        'about_title',
        'about_description',
        'about_image',
        'stat_1_number', 'stat_1_label',
        'stat_2_number', 'stat_2_label',
        'stat_3_number', 'stat_3_label',
        'stat_4_number', 'stat_4_label',
        'showreel_video_url',
        'showreel_title',
        'showreel_description',
    ];
}
