<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WebAdminUser
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

        if ($authUser->level === 'admin') {
            return $next($request);
        }

        
        return dd('403', 'Unauthorised');
        
    }
}
