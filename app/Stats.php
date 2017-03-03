<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    protected $table = 'stats';
    
    protected $fillable = [
        'id',
        'ip_address',
        'country_code',
        'country_name',
        'browser',
        'platform',
        'devicde',
    ];
}
