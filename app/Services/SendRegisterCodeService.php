<?php

namespace App\Services;

use App\Mail\RegisterVerificationEmail;
use App\Traits\SendVerificationCode;

class SendRegisterCodeService implements SendCodeService
{
    use SendVerificationCode;

    protected static function getEmailInstance($receiver, $code)
    {
        return new RegisterVerificationEmail($receiver, $code);
    }
}
