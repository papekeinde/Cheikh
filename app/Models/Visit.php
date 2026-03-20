<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'ip_hash',
        'path',
        'method',
        'user_agent',
        'referer',
    ];
}
