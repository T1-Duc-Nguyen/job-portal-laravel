<?php

namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatListUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $conversation;
    

    public function __construct(
        Conversation $conversation
    ) {
        $this->conversation = $conversation;
    }

    public function broadcastOn()
    {
        $channels = [];

        if ($this->conversation->candidate?->user_id) {

            $channels[] =
                new PrivateChannel(
                    'user.' .
                    $this->conversation
                        ->candidate
                        ->user_id
                );
        }

        if ($this->conversation->employer?->user_id) {

            $channels[] =
                new PrivateChannel(
                    'user.' .
                    $this->conversation
                        ->employer
                        ->user_id
                );
        }

        return $channels;
    }

    public function broadcastAs()
    {
        return 'chat.list.updated';
    }
}