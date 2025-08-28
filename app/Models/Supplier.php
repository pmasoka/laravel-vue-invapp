<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $connection = 'pgsql'; // Use PostgreSQL for supplier data
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    /**
     * Get the products for the supplier.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
