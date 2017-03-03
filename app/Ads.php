<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table = 'ads';
    
    protected $fillable = [
    'id',
    'home_top_ad_code',
    'home_top_ad_img',
    'home_top_ad_active',
    'home_side_ad_code',
    'home_side_ad_img',
    'home_side_ad_active',
    'media_top_ad_code',
    'media_top_ad_img',
    'media_top_ad_active',
    'media_bottom_ad_code',
    'media_bottom_ad_img',
    'media_bottom_ad_active',
    ];
    
    public $timestamps = false;
}
