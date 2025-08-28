<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
     * Return JSON response
     *
     * @param mixed $data
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithSuccess($data = null, $statusCode = 200, $headers = [])
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], $statusCode, $headers);
    }

    /**
     * Return JSON error response
     *
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message, $statusCode = 400, $errors = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Return JSON response for validation errors
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithValidationErrors($validator)
    {
        return $this->respondWithError('Validation failed', 422, $validator->errors());
    }
}