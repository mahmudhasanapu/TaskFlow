<?php

namespace App\Http\Controllers\API\Base;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class BaseApiController extends BaseController
{
    protected function success($data = null, $message = 'Success', $code = 200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($message = 'something went wrong',int $code = 400, ?\Throwable $e = null):JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        //in development, include exception message
        if (app()->environment('local') && $e){
            $response['error'] = $e->getMessage();
        }
        return response()->json($response, $code);
    }
}
