<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WebDealershipUser
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
        $authUser = Auth::user();

        // Admin can access any endpoint
        if ($authUser->level === 'admin') {
            return $next($request);
        }

        if (
            $authUser->level === 'dealership'
        ) {
            $dealershipId = null;
            return $next($request);
            if(
            $request->has('dealershipId') &&
                !empty($request->dealershipId))
            {
                $dealershipId = $request->dealershipId;
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

        return dd('403', 'Unauthorised');
    }
}
