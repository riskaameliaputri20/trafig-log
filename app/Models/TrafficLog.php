<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficLog extends Model
{
    protected $fillable = [
        'ip_address',
        'access_time',
        'request_method',
        'request_uri',
        'user_agent',
        'status_code',
        'response_size',
        'referrer',
    ];
}
