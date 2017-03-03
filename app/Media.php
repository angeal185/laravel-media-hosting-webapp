<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    
    protected $fillable = [
        'id',
        'short_url',
        'user_id',
        'category_id',
        'title',
        'description',
        'active',
        'views',
        'is_video',
        'is_picture',
        'pic_url',
        'vid_url',
        'vid_type',
        'vid_img',
    ];
}
