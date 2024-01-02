<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function add($friend_id)
    {
        $friend = User::find($friend_id);

        if ($friend) {
            Auth::user()->add($friend);
            return $this->successResponse([
                "message" => "Add Friend Successfully."
            ]);
        }

        return $this->failResponse("User Not Found", 404);
    }

    public function accept($friend_id)
    {
        $friend = User::find($friend_id);

        if ($friend) {
            Auth::user()->accept($friend);
            return $this->successResponse([
                "message" => "You are friend now."
            ]);
        }

        return $this->failResponse("User Not Found", 404);
    }

    public function unfriend($id)
    {
        $user = User::find($id);
        Auth::user()->unfriend($user);
    }

    public function friendList()
    {
        return Auth::user()->listOfFriends();
    }

    public function strangers(){
        return Auth::user()->strangers();
    }
}
