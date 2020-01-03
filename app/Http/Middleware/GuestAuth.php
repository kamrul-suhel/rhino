<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class GuestAuth
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
        if(session()->has('uniqueId')){
            $uniqueId = session()->get('uniqueId');
            $request->merge(compact('uniqueId'));
            return $next($request);
        }else{
            return redirect('/');
        }
    }
}
