<?php

namespace App\Listeners;

use App\Models\ProductActivityLog;
use Carbon\Carbon;

class LogProductActivity
{
    public function handle($event)
    {
        ProductActivityLog::create([
            'user_id'      => $event->user->id ?? null,
            'action'       => $event->action, // use action passed from controller
            'product_id'   => $event->product->id,
            'product_name' => $event->product->name,
            'metadata'     => [
                'changes' => method_exists($event->product, 'getChanges')
                                ? $event->product->getChanges()
                                : [],
            ],
            'timestamp'    => Carbon::now(),
        ]);
    }
}
