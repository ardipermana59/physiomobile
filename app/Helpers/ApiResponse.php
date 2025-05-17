<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'success'  => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function error(string $message = 'Error', int $status = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'success'  => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return self::error($message, 401);
    }

    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, 403);
    }

    public static function notFound(string $message = 'Not Found'): JsonResponse
    {
        return self::error($message, 404);
    }

    public static function validationError(mixed $errors, string $message = 'Validation Error'): JsonResponse
    {
        return self::error($message, 422, $errors);
    }

    public static function serverError(string $message = 'Server Error'): JsonResponse
    {
        return self::error($message, 500);
    }
}
