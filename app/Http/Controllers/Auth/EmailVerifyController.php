<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return $this->successResponse([
            "message" => "Successfully Verified"
        ]);
    }
}
