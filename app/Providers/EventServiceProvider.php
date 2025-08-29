<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Events\ProductActionEvent;
use App\Listeners\LogUserActivity;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogProductActivity;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            LogUserActivity::class,
        ],
        Login::class => [
            LogUserActivity::class,
        ],
        Logout::class => [
            LogUserActivity::class,
        ],
        Failed::class => [
            LogUserActivity::class,
        ],
        ProductActionEvent::class => [
            LogProductActivity::class,
        ],

    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = false; // must be static in Laravel 12
}
