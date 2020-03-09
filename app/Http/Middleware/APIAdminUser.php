<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use JWTAuth;

class APIAdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authUser = JWTAuth::parseToken()->authenticate();

        if ($authUser->level === 'admin') {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'forbidden',
            'error_code' => Response::HTTP_FORBIDDEN
        ], Response::HTTP_FORBIDDEN);
    }
}
