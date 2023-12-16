<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    use ApiResponse;

    public function change(Request $request)
    {
        $validators = Validator::make($request->all(),[
            "oldPassword" => "required|min:8",
            "password" => "required|min:8|confirmed"
        ]);

        if($validators->fails()){
            return $this->failResponse("Something Went Wrong!",401,$validators->errors());
        }

        $user = User::find(Auth::id());

        if(!Hash::check($request->oldPassword,$user->password)){
            return $this->failResponse("Incorrect Password!",401,["message" => "Your Password is incorrect!"]);
        }

        $user->password = Hash::make($request->password);
        $user->update();

        return $this->successResponse([
            "message" => "Changed Password Successfully"
        ]);
    }
}
