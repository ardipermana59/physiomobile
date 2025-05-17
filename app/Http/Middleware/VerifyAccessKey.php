<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Closure;

class VerifyAccessKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessKey = $request->header('accessKey');

        if ($accessKey !== env('ACCESS_KEY')) {
            return  ApiResponse::unauthorized();
        }

        return $next($request);
    }
}
