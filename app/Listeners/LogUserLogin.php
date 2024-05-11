<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Auth\Events\Login;
use App\Models\User;

class LogUserLogin
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(Login $event): void
    {
        $user = $event->user;
        if ($event->user instanceof User) {

            
            activity('user_activity')
                ->causedBy($event->user)
                ->log('User logged in');
        }
    }
}
