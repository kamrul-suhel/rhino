<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WebSalesExecutiveUser
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
        if(
            $authUser->level === 'admin' ||
            $authUser->level === 'dealership'
        ){
            return $next($request);
        }

        if($authUser->level === 'sales_executive'){

        }

        
        return dd('403', 'Unauthorised');
    }
}
