<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
       $request->user()->currentAccessToken()->delete();

       return $this->successResponse([
            "message" => "Logout Successfully"
       ]);
    }
}
