<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $ids = [$this->message->sender_id, $this->message->receiver_id];
        sort($ids);
        return new Channel('chat.'.implode('.', $ids));
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message->load('sender'),
            'receiver_id' => $this->message->receiver_id
        ];
    }
}
