<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function success($data = null, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], $status);
    }

    public function error(string $message = 'Something went wrong', int $status = 500, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors
        ], $status);
    }
}