<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductActionEvent
{
    use Dispatchable, SerializesModels;

    public Product $product;
    public string $action;

    public function __construct(Product $product, string $action)
    {
        $this->product = $product;
        $this->action = $action; // created | updated | deleted
    }
}
