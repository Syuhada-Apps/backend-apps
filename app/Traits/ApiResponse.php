<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponse
{
    public function successResponse($message, $data = '', $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function errorResponse($message, $data = null, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function errorValidationResponse($data, $message = 'Validation input error', $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $data
        ], $statusCode);
    }
}
