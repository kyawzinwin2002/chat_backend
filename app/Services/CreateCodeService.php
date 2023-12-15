<?php

namespace App\Services;

use App\Models\Code;

class CreateCodeService
{
    public static function create($receiver_id, $type)
    {
        $verify_code = rand(111111, 999999);

        Code::create([
            "code" => $verify_code,
            "user_id" => $receiver_id,
            "type" => $type
        ]);

        return $verify_code;
    }
}
