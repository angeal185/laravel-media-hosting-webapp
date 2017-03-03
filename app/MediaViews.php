<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaViews extends Model
{
    protected $table = 'media_views';
    
    protected $fillable = [
        'id',
        'ip_address',
        'media_id',
        'views',
    ];
}
