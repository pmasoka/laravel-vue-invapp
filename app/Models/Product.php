<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'pgsql';   // use PostgreSQL
    protected $table = 'products';

    protected $fillable = ['name', 'price', 'description'];
}
