<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\PhotoMessage;
use App\Models\TextMessage;
use App\Services\SendMessageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $conversation = Conversation::find($request->conversation_id);

        if (!$conversation) {
            $conversation = Conversation::create();
            Auth::user()->conversations()->attach($conversation);
        }

        //Store Message in the Database and public directory and Send;
        SendMessageService::send($this->store($request));

        //Response Sent Message
        return $this->successResponse([
            "message" => "Send Message Successfully"
        ]);
    }

    protected function store($request)
    {
        if ($request->hasFile("message")) {
            $file = $request->file("message");
            $fileType = $file->getMimeType();

            if (strpos($fileType, "image") !== false) {
                $request->validate([
                    "message" => "required|image"
                ]);

                $newFileName = time() . uniqid() . rand(111111, 999999) . $file->getClientOriginalName();

                $path = $file->storeAs("photoMessages", $newFileName, "public");

                $polyMessage = PhotoMessage::create([
                    "url" => $path
                ]);
            }
        } else {
            $polyMessage = TextMessage::create([
                "content" => $request->message
            ]);
        };

        $message = new Message();
        $message->conversation_id = $request->conversation_id;
        $message->user_id = Auth::id();
        $message->messageable()->associate($polyMessage);
        $message->save();

        return $message;
    }
}
