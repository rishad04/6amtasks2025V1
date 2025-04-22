<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedListener implements ShouldQueue
{
    use InteractsWithQueue;
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
    public function handle(object $event): void
    {
        if ($event instanceof User) {
            // Logic to execute when a user is created
            dd('here in event listener');
            Log::info('A New User Registerd : ' . $event->name . ' (ID: ' . $event->id . ')');
            // You could send a welcome email here, for example
        }
    }
}
