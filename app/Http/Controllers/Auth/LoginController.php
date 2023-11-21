<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only(["email", "password"]))) {
           return $this->successResponse([
                "message" => "LoginSuccessfully",
                "user" => Auth::user(),
                "token" => Auth::user()->createToken(Auth::id())->plainTextToken
            ]);
        }

        return $this->failResponse("Crendentials are wrong!",401);
    }
}
