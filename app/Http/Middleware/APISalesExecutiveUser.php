<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use JWTAuth;

class APISalesExecutiveUser
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
        $authUser = JWTAuth::parseToken()->authenticate();

        // Admin can access any endpoint
        if(
            $authUser->level === 'admin' ||
            $authUser->level === 'dealership'
        ){
            return $next($request);
        }

        if($authUser->level === 'sales_executive'){

        }

        return response()->json([
            'success' => false,
            'message' => 'forbidden',
            'error_code' => Response::HTTP_FORBIDDEN
        ],Response::HTTP_FORBIDDEN);
    }
}
