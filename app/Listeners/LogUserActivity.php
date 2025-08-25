<?php

namespace App\Listeners;

use App\Models\UserActivityLogs;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogUserActivity
{
    public function handle($event)
    {
        $userId = $event->user->id ?? null;

        $action = match (true) {
            $event instanceof Registered => 'register',
            $event instanceof Login      => 'login',
            $event instanceof Logout     => 'logout',
            default                      => 'unknown',
        };

        UserActivityLogs::create([
            'user_id'    => $userId,
            'action'     => $action,
            'ip_address' => request()->ip(),
            'metadata'   => [
                'browser' => request()->header('User-Agent'),
                'device'  => PHP_OS,
            ],
            'timestamp' => now(),  // this respects the app timezone
        ]);
    }
}
