<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $receiverId;

    public $count;

    public function __construct(
        $receiverId,
        $count
    ) {
        $this->receiverId = $receiverId;
        $this->count = $count;
    }

    public function broadcastOn()
    {
        return new PrivateChannel(
            'user.' . $this->receiverId
        );
    }

    public function broadcastAs()
    {
        return 'new.message.notification';
    }
}