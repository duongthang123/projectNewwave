<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $image;

    /**
     * Create a new event instance.
     */
    public function __construct($user, $message, $image)
    {
        $this->user = $user;
        $this->message = $message;
        $this->image = $image;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }
}
