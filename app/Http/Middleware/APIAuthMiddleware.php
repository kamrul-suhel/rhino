<?php

namespace App\Http\Middleware;

use Closure;

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
        $requestToken = $request->header('api-token');
        $token = env('API_TOKEN');

        if(trim($requestToken) == trim($token)){
            return $next($request);
        }else{
            return response(['Token mismatch', 403]);
        }

    }
}
