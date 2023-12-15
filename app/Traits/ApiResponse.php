<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($data = [])
    {
        return $this->sendResponse(200, [
            "status" => true,
            "data" => $data
        ]);
    }

    public function failResponse($errorMessage, $code, $errors = [])
    {
        return $this->sendResponse($code, [
            "status" => false,
            "message" => $errorMessage,
            "errors" => $errors,
        ]);
    }

    public function sendResponse($code, $data = [])
    {
        return response()->json($data, $code);
    }
}
