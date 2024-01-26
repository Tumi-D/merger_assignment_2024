<?php
namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Return a success response.
     *
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(array $data = [], $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }

    /**
     * Return a failure response.
     *
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failureResponse( $statusCode = 400)
    {
        return response()->json(['status' => 'failure'], $statusCode);
    }
}
