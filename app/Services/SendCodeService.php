<?php

namespace App\Services;

interface SendCodeService
{
    public static function send($receiver,$codeType);
}
