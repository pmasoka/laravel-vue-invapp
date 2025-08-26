<?php

namespace App\Listeners;

use App\Models\UserActivityLogs;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Carbon\Carbon;

class LogUserActivity
{
    public function handle($event)
    {
        $userId = $event->user->id ?? null;

        $action = match (true) {
            $event instanceof Registered    => 'register',
            $event instanceof Login         => 'login',
            $event instanceof Logout        => 'logout',
            $event instanceof Failed        => 'failed_login',
            default                         => 'unknown',
        };

        UserActivityLogs::create([
            'user_id'    => $userId,
            'action'     => $action,
            'ip_address' => request()->ip(),
            'metadata'   => [
                'browser' => request()->header('User-Agent'),
                'device'  => PHP_OS,
            ],
            'timestamp'  => Carbon::now(),
        ]);
    }
}
