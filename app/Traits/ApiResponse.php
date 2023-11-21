<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($data = [])
    {
        return $this->sendResponse([
            "status" => true,
            "data" => $data
        ],200);
    }

    public function failResponse($errorMessage,$code,$errors = [])
    {
        return $this->sendResponse([
            "status" => false,
            "message" => $errorMessage,
            "errors" => $errors,
        ],$code);
    }

    public function sendResponse($data = [],$code)
    {
        return response()->json($data,$code);
    }
}
