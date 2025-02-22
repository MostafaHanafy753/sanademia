<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = new \stdClass, $code = 200)
    {
    	$response = [
            'success' => false,
            'message' => $errorMessages,
        ];

        //$response['data'] = $errorMessages;
        return response()->json($response, $code);
    }
}
