<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($data = [])
    {
        return $this->sendResponse([
            "status" => "success",
            "data" => $data
        ],200);
    }

    public function failResponse($errorMessage,$code,$errors = [])
    {
        return $this->sendResponse([
            "status" => "error",
            "message" => $errorMessage,
            "errors" => $errors,
        ],$code);
    }

    public function sendResponse($data = [],$code)
    {
        return response()->json($data,$code);
    }
}
