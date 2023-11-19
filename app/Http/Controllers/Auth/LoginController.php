<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only(["email", "password"]))) {
            return response()->json([
                "status" => true,
                "message" => "LoginSuccessfully",
                "user" => Auth::user(),
                "token" => Auth::user()->createToken(Auth::id())->plainTextToken
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Credentials are wrong!"
        ]);
    }
}
