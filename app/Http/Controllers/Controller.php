<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Check if the request expects JSON response
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiRequest(Request $request)
    {
        return $request->expectsJson() || $request->is('api/*');
    }

    /**
     * Return appropriate response based on request type
     *
     * @param Request $request
     * @param mixed $data
     * @param string|null $view
     * @param array $viewData
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    protected function respond(Request $request, $data = null, $view = null, $viewData = [], $statusCode = 200)
    {
        if ($this->isApiRequest($request)) {
            return response()->json($data, $statusCode);
        }

        if ($view) {
            return view($view, array_merge($viewData, is_array($data) ? $data : ['data' => $data]));
        }

        return $data;
    }

    /**
     * Return appropriate redirect response based on request type
     *
     * @param Request $request
     * @param string $route
     * @param string $message
     * @param string $status
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function respondWithRedirect(Request $request, $route, $message = '', $status = 'success')
    {
        if ($this->isApiRequest($request)) {
            return response()->json([
                'message' => $message,
                'status' => $status,
                'redirect' => $route ? route($route) : null
            ], 200);
        }

        return redirect()->route($route)->with($status, $message);
    }
}
