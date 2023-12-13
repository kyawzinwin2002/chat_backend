<?php

namespace App\Traits;

use App\Services\CreateCodeService;
use App\Services\SendEmailService;

trait SendVerificationCode
{
    public static function send($receiver, $codeType)
    {
        $code = CreateCodeService::create($receiver->id, $codeType);

        $email = static::getEmailInstance($receiver, $code);

        SendEmailService::send($receiver, $email);
    }

    abstract protected static function getEmailInstance($receiver, $code);
}
