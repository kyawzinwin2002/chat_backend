<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\PhotoMessage;
use App\Models\TextMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function get($conversation_id)
    {
        $conversation = Auth::user()->conversations()->find($conversation_id);

        if(!$conversation){
            return $this->failResponse("You're not friends!",404);
        }

        $messages = [];

        foreach($conversation->messages as $message){
            if($message->messageable_type == PhotoMessage::class){
                $message->messageable = [
                    "url" => asset("storage/".$message->messageable->url)
                ];
            }
            $messages[] = [
                "message" => $message->messageable,
                "sender" => $message->user,
                "type" => $message->messageable_type == TextMessage::class ? "text" : "photo"
            ];
        }

        return $this->successResponse([
            "messages" => array_reverse($messages)
        ]);
    }
}
