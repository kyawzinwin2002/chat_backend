<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class SendCodeService
{
    public static function send($receiver, $email)
    {
        Mail::to($receiver->email)->send($email);
    }
}
