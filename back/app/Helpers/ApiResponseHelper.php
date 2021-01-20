<?php


namespace App\Helpers;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseHelper
{
    /**
     * Retorna um response HTTP de sucesso em Json
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function success(string $message): JsonResponse {
        return response()->json([
            'success' => 1,
            'message' => $message,
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Retorna um response HTTP de erro em Json
     *
     * @param string $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function error(string $message, int $code): JsonResponse {
        return response()->json([
            'error' => 1,
            'message' => $message,
        ], $code);
    }
}
