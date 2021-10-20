<?php

namespace App\Traits;

trait ResponseFormat
{
    public function sendResponse($result, $status = "success", $code = "200")
    {
        $response = [
            'data' => $result,
            'status' => $status,
            'code' => $code,
        ];
        return response()->json($response, 200);
    }
}
