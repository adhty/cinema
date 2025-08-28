<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Check if the request expects JSON response
     */
    protected function isApiRequest(Request $request): bool
    {
        return $request->expectsJson() || $request->is('api/*');
    }

    /**
     * Return success response for API
     */
    protected function successResponse(array $data = [], string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Return error response for API
     */
    protected function errorResponse(string $message = 'Error', int $statusCode = 400, array $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Return appropriate response based on request type
     */
    protected function respond(Request $request, $data = null, string $view = null, array $viewData = [], int $statusCode = 200)
    {
        if ($this->isApiRequest($request)) {
            return $this->successResponse(is_array($data) ? $data : ['data' => $data], 'Success', $statusCode);
        }

        if ($view) {
            return view($view, array_merge($viewData, is_array($data) ? $data : ['data' => $data]));
        }

        return $data;
    }

    /**
     * Return appropriate redirect response based on request type
     */
    protected function respondWithRedirect(Request $request, string $route, string $message = '', string $status = 'success')
    {
        if ($this->isApiRequest($request)) {
            return $this->successResponse([
                'redirect' => $route ? route($route) : null
            ], $message);
        }

        return redirect()->route($route)->with($status, $message);
    }

    /**
     * Handle validation errors consistently
     */
    protected function handleValidationError(Request $request, array $errors, string $message = 'Validation failed')
    {
        if ($this->isApiRequest($request)) {
            return $this->errorResponse($message, 422, $errors);
        }

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
