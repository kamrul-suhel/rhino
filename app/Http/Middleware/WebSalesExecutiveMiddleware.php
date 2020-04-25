<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WebSalesExecutiveMiddleware
{
    protected $authUser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->authUser = Auth::user();
        // if user is admin return
        if ($this->authUser->level === 'admin') {
            return $next($request);
        }

        // If user is dealership then check all kind of
        if ($this->authUser->level === 'dealership') {
            $dealershipMiddleware = new WebDealershipMiddleware();
            return $dealershipMiddleware->dealershipCanAccess($request, $next, $this->authUser);
        }

        return redirect('/admin/dashboard??accessDenied=true');
    }
}
