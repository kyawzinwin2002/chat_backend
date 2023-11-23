<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    use ApiResponse;

    public function add($friend_id)
    {
        $friend = User::find($friend_id);

        if($friend){
            Auth::user()->add($friend);
            return $this->successResponse([
                "message" => "Add Friend Successfully."
            ]);
        }

        return $this->failResponse("User Not Found",404);
    }

    public function accept($friend_id)
    {
        $friend = User::find($friend_id);

        if($friend){
            Auth::user()->accept($friend);
            return $this->successResponse([
                "message" => "You are friend now."
            ]);
        }

        return $this->failResponse("User Not Found",404);
    }

    public function friendList()
    {
        return Auth::user()->listOfFriends();
    }

    public function strangers()
    {
        $friends = Auth::user()->listOfFriends();
        $friendIds = $friends->pluck("id")->toArray();

        return User::whereNotIn("id",$friendIds)
            ->where("id","<>",Auth::id())
            ->get();
    }
}