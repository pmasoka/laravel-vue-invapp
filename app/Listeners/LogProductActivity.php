<?php

namespace App\Listeners;

use App\Models\ProductActivityLog;
use Carbon\Carbon;

class LogProductActivity
{
    public function handle($event)
    {
        $action = match (get_class($event)) {
            \App\Events\ProductActionEvent::class => 'product_created',
            default => 'unknown',
        };

        ProductActivityLog::create([
            'user_id'      => $event->user->id ?? null,
            'action'       => $action,
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
