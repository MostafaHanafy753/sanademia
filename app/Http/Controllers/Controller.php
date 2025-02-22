<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\ImagesOperations;
use stdClass;

abstract class Controller
{
    use ApiResponse,ImagesOperations;
    public function sendResponse($result = new stdClass, $message = '', $status_code = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
            'status_code' => $status_code
        ];
        return response()->json($response, $status_code);
    }


    public function getVideoDuration($videoPath)
    {

        $getID3 = new \getID3;
        $file = $getID3->analyze($videoPath);
        $playtime_seconds = $file['playtime_seconds'];
//        $duration = date('H:i:s.v', $playtime_seconds);

        return $playtime_seconds / 60;

//        $video = FFMpeg::open($videoPath);
//        $duration = $video->getDurationInSeconds();
//        $minutes = $duration / 60;
//
//        return $minutes;
    }
}
