<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'pgsql'; // Use PostgreSQL for product data
    protected $table = 'products';    // Specify the table name if it's different from the model name

    protected $fillable = [
        'name',
        'quantity',
        'unit_price',
        'total_price',
        'description',
        'category_id', // The foreign key referencing categories
        'supplier_id', // The foreign key referencing suppliers
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
        'total_price'=> 'decimal:2',
    ];

    // Method to define relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Method to define relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
