<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\UserActivityLogs;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\PasswordResetLinkSent;

class LogUserActivity
{
    public function handle($event)
    {
        $userId = $event->user->id ?? null;

        $action = match (true) {
            $event instanceof Registered           => 'register',
            $event instanceof Login                => 'login',
            $event instanceof Logout               => 'logout',
            $event instanceof Failed               => 'failed_login',
            $event instanceof PasswordReset        => 'password_reset',
            $event instanceof PasswordResetLinkSent => 'password_reset_link_sent',
            default                                => 'unknown',
        };

        UserActivityLogs::create([
            'user_id'    => $userId,
            'action'     => $action,
            'ip_address' => request()->ip(),
            'metadata'   => [
                'browser' => request()->header('User-Agent'),
                'device'  => PHP_OS,
                'email'   => $event instanceof Failed
                    ? $event->credentials['email'] ?? null
                    : ($event instanceof PasswordReset ? $event->user->email : null),
            ],
            'timestamp'  => Carbon::now(),
        ]);
    }
}
