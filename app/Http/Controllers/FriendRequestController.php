<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $friendRequest = FriendRequest::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $request->receiver_id,
            "status" => Status::Pending
        ]);

        return $this->successResponse([
            "message" => "Sent request successfully!",
            "request" => $friendRequest
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $request_id)
    {
        $friendRequest = FriendRequest::find($request_id);

        if ($friendRequest) {
            $friendRequest->update([
                "status" => Status::Accepted
            ]);

            Friendship::create([
                "user_id" => Auth::id(),
                "friend_id" => $request->sender_id
            ]);

            return $this->successResponse([
                "message" => "You are friends now."
            ]);
        }

        return $this->failResponse("Request Not Found!", 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request_id)
    {
        $friendRequest = FriendRequest::find($request_id);

        if ($friendRequest) {
            $friendRequest->delete();

            return $this->successResponse([
                "message" => "Deleted request!"
            ]);
        }

        return $this->failResponse("Request Not Found!", 404);
    }
}
