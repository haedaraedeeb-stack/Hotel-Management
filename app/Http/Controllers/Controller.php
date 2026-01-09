<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function success($message='', $data = [], $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
    public function error($message='error', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
