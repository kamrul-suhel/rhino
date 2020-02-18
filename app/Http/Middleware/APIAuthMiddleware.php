<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class APIAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestToken = $request->header('API-TOKEN');
        return $next($request);
        $verify = password_verify(env('SECURITY_CODE'), $requestToken);

        if($verify){
            return $next($request);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Token mismatch'
            ], Response::HTTP_FORBIDDEN);
        }

    }
}
