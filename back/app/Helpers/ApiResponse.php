<?php


namespace App\Helpers;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    /**
     * Retorna um response HTTP de sucesso em Json
     *
     * @param string|array $message
     *
     * @return JsonResponse
     */
    public static function success(string|array $message): JsonResponse {
        if (is_array($message)) {
            return response()->json($message, Response::HTTP_ACCEPTED);
        }

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
