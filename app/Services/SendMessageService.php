<?php

namespace App\Services;

use App\Events\SendMessage;

class SendMessageService
{
    public static function send($message)
    {
        SendMessage::dispatch($message);
    }
}
