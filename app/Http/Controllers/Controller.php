<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

/**
 * Abstract Controller class for JSON API responses.
 * Summary of Controller
 * @package App\Http\Controllers
 */
abstract class Controller extends BaseController
{
    /**
     * Return a JSON success response.
     * Summary of success
     * @param mixed $message
     * @param mixed $data
     * @param mixed $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message='', $data = [], $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * Return a JSON error response.
     * Summary of error
     * @param mixed $message
     * @param mixed $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message='error', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
