<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Response;
use JWTAuth;

class APICallHandlerReceptionist
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

        switch($authUser->level){
            case USER::USERADMIN:
                return $next($request);
                break;

            case User::USERDEALERSHIP:
            case User::USERCALLHANDLER:
            case User::USERRECEPTIONIST:
            case User::USERSALEEXECUTIVE:
                $dealershipId = null;
                if(
                    $request->has('dealershipId') &&
                    !empty($request->dealershipId))
                {
                    $dealershipId = $request->dealershipId;
                }

                if((int) $dealershipId == (int) $authUser->dealership_id){
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
