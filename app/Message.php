<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    
    protected $fillable = [
        'id','msg_from','msg_to','email','is_registed','msg_content','status',
    ];
}
