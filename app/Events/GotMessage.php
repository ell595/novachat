<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GotMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $message)
    {
        //
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            "notification" => "You have received a new message",
        ];
    }

    public function broadcastOn(): array
    {
        //$message = $this->message;
        return [
            new PrivateChannel('room_' . $this->message['room_id']),
        ];
    }

    public function broadcastAs()
    {
        return 'GotMessage';
    }
}
