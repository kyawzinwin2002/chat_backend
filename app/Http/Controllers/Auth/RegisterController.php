<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SendCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Validation Error!",
                "errors" => $validator->errors()
            ]);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        //Send code to user
        $codeService = new SendCodeService();
        $codeService->send($user);

        Auth::login($user);

        return response()->json([
            "status" => true,
            "message" => "Registered Successfully!",
            "user" => Auth::user(),
            "token" => Auth::user()->createToken($user->id)->plainTextToken
        ]);
    }
}
