<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function check(Request $request)
    {
        $validators = Validator::make($request->all(),[
            "email" => "required|string|email|exists:users,email"
        ],["email.exists" => "Something Went Wrong!"]);

        if($validators->fails()){
            return $this->failResponse("Something Went Wrong!",401,$validators->errors());
        }

        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => __($response)], 200)
            : response()->json(['error' => __($response)], 422);

    }

    public function reset(Request $request)
    {
        $validators = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|min:8|confirmed",
            "token" => "required"
        ]);

        if($validators->fails()){
            return $this->failResponse("Something Went Wrong!",401,$validators->errors());
        }

        $response = Password::reset($request->only("email","password","password_confirmation","token"),function($user, $password){
            $user->password = Hash::make($password);
            $user->update();
        });

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => __($response)], 200)
            : response()->json(['error' => __($response)], 422);
    }
}
