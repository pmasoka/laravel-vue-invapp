<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class UserActivityLogs extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'user_activities';

    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'metadata',
        'timestamp',
    ];

    protected $casts = [
        'metadata' => 'array',
        'timestamp' => 'datetime',
    ];
}
