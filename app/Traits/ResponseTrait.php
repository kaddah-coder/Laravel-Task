<?php

namespace App\Traits;

trait ResponseTrait
{
    function sendResponse($msg, $data, $authorisation = null, $code = null)
    {
        return response()->json([
            'status' => 'Success',
            'msg' => $msg,
            'result' => [
                'data' => $data,
            ],
            'authorisation' => $authorisation,
            'statusCode' => $code,
        ]);
    }

    function sendError($msg, $code = null)
    {
        return response()->json([
            'status' => 'Fail',
            'msg' => $msg,
            'stutusCode' => $code,
        ]);
    }
}
