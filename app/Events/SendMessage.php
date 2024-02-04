<?php

namespace App\Events;

use App\Models\PhotoMessage;
use App\Models\TextMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        if($message->messageable_type == PhotoMessage::class){
            $message->messageable = [
                "url" => asset("storage/".$message->messageable->url)
            ];
        }
        $newMessage = [
            "message" => $message->messageable,
            "sender" => $message->user,
            "type" => $message->messageable_type == TextMessage::class ? "text" : "photo",
            "conversation_id" => $message->conversation_id
        ];

        $this->message = (object) $newMessage;

        // $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('message.' . $this->message->conversation_id),
        ];
    }

    public function broadcastAs()
    {
        return "sendMessageEvent";
    }
}
