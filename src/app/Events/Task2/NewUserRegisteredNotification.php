<?php

namespace App\Events\Task2;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewUserRegisteredNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    use SerializesModels;

    public $username;

    public function __construct($username)
    {
        $this->username = $username;

        // Cache::put('latest_notification', "👤 New user registered: {$username}", 60);


    }

    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    public function broadcastAs()
    {
        return 'new.user.registered';
    }

    public function broadcastWith()
    {
        return ['message' => "{$this->username} just joined us, say hello!"];
    }
}
