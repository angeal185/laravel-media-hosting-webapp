<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaFlags extends Model
{
    protected $table = 'media_flags';
    
    protected $fillable = [
        'id','user_id','media_id',
    ];
}
