<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentFlags extends Model
{
    protected $table = 'comments_flags';
    
    protected $fillable = [
        'id','user_id','comment_id',
    ];
}
