<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use JWTAuth;

class APIDealershipUser
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

        // Admin can access any endpoint
        if ($authUser->level === 'admin') {
            return $next($request);
        }

        if ($authUser->level === 'dealership') {
            $dealershipId = null;
            if(
            $request->has('dealershipId') &&
                !empty($request->dealershipId))
            {
                $dealershipId = $request->dealershipId;
            }

            if(
                $request->has('dealership_id') &&
                !empty($request->dealership_id))
            {
                $dealershipId = $request->dealership_id;
            }

            if((int) $dealershipId === (int) $authUser->dealership_id){
                return $next($request);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'dealershipMismatch',
                    'error_code' => Response::HTTP_FORBIDDEN
                ], Response::HTTP_FORBIDDEN);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'forbidden',
            'error_code' => Response::HTTP_FORBIDDEN
        ], Response::HTTP_FORBIDDEN);
    }
}
