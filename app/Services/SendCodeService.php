<?php

namespace App\Services;

use App\Enums\CodeType;
use App\Mail\VerificationEmail;
use App\Models\Code;
use Illuminate\Support\Facades\Mail;

class SendCodeService
{
    public function send($user)
    {
        $verify_code = rand(111111, 999999);

        $code = Code::create([
            "code" => $verify_code,
            "user_id" => $user->id,
            "type" => CodeType::Verify,
        ]);

        $email = new VerificationEmail($user, $code);
        Mail::to($user->email)->send($email);
    }
}
