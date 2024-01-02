<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function get()
    {
        $user = User::find(Auth::id());

        return $this->successResponse([
            "conversations" => $user->conversations
        ]);
    }

    public function show($id)
    {
        $conversation = Conversation::find($id);

        if(!$conversation){
            return $this->failResponse("Not Found",404,[
                "conversation" => "Not Found!"
            ]);
        }

        return $this->successResponse([
            "messages" => $conversation->messages
        ]);
    }

    public function delete($id)
    {
        $conversation = Conversation::find($id);

        if(!$conversation){
            return $this->failResponse("Not Found",404,[
                "conversation" => "Not Found!"
            ]);
        }

        $conversation->delete();

        return $this->successResponse([
            "message" => "Deleted conversation successfullly"
        ]);
    }
}
