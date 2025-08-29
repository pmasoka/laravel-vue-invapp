<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class ProductActivityLog extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'product_activities';

    protected $fillable = [
        'user_id',
        'action',
        'product_id',
        'product_name',
        'metadata',
        'timestamp',
    ];

    protected $casts = [
        'metadata'  => 'array',
        'timestamp' => 'datetime',
    ];
}
