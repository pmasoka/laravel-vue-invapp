<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductActionEvent
{
    use Dispatchable, SerializesModels;

    /** @var Product */
    public $product;

    /** @var string */
    public $action;

    /**
     * @param Product $product
     * @param string $action   // e.g., 'created', 'updated', 'deleted'
     */
    public function __construct(Product $product, string $action)
    {
        $this->product = $product;
        $this->action = $action;
    }
}
