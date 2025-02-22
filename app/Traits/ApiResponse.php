<?php

namespace App\Traits;

use Illuminate\Database\QueryException;

trait ApiResponse
{

    public string $SUCCESS_MESSAGE = 'Success';
    public string $ERROR_MESSAGE = 'Error';
    public string $NOT_FOUND_ERROR_MESSAGE = 'NOT FOUND';
    public int $SUCCESS_CODE = 200;
    public int $SERVER_ERROR_CODE = 500;
    public int $INVALID_PARAMETERS_ERROR_CODE = 400;
    public int $NOT_FOUND_ERROR_CODE = 404;
    public int $UNAUTHORIZED_ERROR_CODE = 401;

    function apiResponse($data, $message, $status)
    {
        return response(['data' => $data, 'message' => $message, 'status' => $status], $status);
    }


    /**
     * @param \Exception $e
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function handleQueryException(\Exception $e): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Response
    {
        if ($e instanceof QueryException) {
            $errorCode = $e->getCode();

            return match ($errorCode) {
                '1062' => $this->apiResponse(null, 'Duplicate entry.', $this->SERVER_ERROR_CODE),
                '1215', '1452', '1451' => $this->apiResponse(null, 'Foreign key constraint violation.', $this->SERVER_ERROR_CODE),
                '1064' => $this->apiResponse(null, 'Syntax error in the query.', $this->SERVER_ERROR_CODE),
                '1045' => $this->apiResponse(null, 'Access denied.', $this->SERVER_ERROR_CODE),
                '1146' => $this->apiResponse(null, 'Table not found.', $this->SERVER_ERROR_CODE),
                '1366' => $this->apiResponse(null, 'Data truncation error.', $this->SERVER_ERROR_CODE),
                '2002' => $this->apiResponse(null, 'Could not connect to the MySQL server.', $this->SERVER_ERROR_CODE),
                '2013' => $this->apiResponse(null, 'Connection to the MySQL server was lost.', $this->SERVER_ERROR_CODE),
                '23000' => $this->apiResponse(null, 'foreign key constraint fails', $this->SERVER_ERROR_CODE),
                '22007' => $this->apiResponse(null, 'Invalid datetime format', $this->SERVER_ERROR_CODE),
                'HY000' => $this->apiResponse(null, 'General error', $this->SERVER_ERROR_CODE),
                '42S02' => $this->apiResponse(null, 'Base table or view not found', $this->SERVER_ERROR_CODE),
                '42S22' => $this->apiResponse(null, 'Column not found', $this->SERVER_ERROR_CODE),
                '1205' => $this->apiResponse(null, 'Lock wait timeout exceeded; try restarting transaction', $this->SERVER_ERROR_CODE),
                '22001' => $this->apiResponse(null, 'Data too long for column', $this->SERVER_ERROR_CODE),
                '24000' => $this->apiResponse(null, 'Invalid cursor state', $this->SERVER_ERROR_CODE),

                default => $this->apiResponse(null, $e->getMessage(), $this->SERVER_ERROR_CODE),
            };
        }

        return $this->apiResponse('', $e->getMessage(), 500);
    }
}
