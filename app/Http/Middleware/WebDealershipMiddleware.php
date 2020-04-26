<?php

namespace App\Http\Middleware;

use App\Event;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class WebDealershipMiddleware
{

    protected $authUser;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
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
            return $this->dealershipCanAccess($request, $next);
        }

        return redirect('/admin/dashboard??accessDenied=true');
    }

    /**
     * @param $request
     * @param $next
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function dealershipCanAccess($request, $next, $authUser = null){
        if($authUser){
            $this->authUser = $authUser;
        }


        $routeName = $request->route()->getName();
        switch ($routeName) {
            case 'UsersEdit': // Check user belongs to dealership
                $userId = $request->id;
                if ($this->dealershipCanEditUser($userId)) {
                    return $next($request);
                }
                return $this->redirectForbidden();
                break;

            case 'EditDealerships': // Check auth user belong to this dealership
                $dealershipId = $request->id;
                if ($this->canEditDealership($dealershipId)) {
                    return $next($request);
                }
                return $this->redirectForbidden();

            case 'EditDealershipEvent': // Dealership can edit events
                $dealershipId = $request->dealershipId;
                $eventId = $request->id;

                if($this->dealershipCanEditEvent($dealershipId, $eventId)){
                    return $next($request);
                }
                return $this->redirectForbidden();

            case 'EventSales': // Dealership can edit events
                $dealershipId = $this->authUser->dealership_id;
                $eventId = $request->eventId;

                if($this->dealershipCanEditEvent($dealershipId, $eventId)){
                    return $next($request);
                }
                return $this->redirectForbidden();

            case 'EventsAnalytics': // Dealership can show events analytics
                $dealershipId = $this->authUser->dealership_id;
                $eventId = $request->id;

                if($this->dealershipCanEditEvent($dealershipId, $eventId)){
                    return $next($request);
                }

                return $this->redirectForbidden();

            case 'CreateDealershipsUser': // Dealership can create user
                $dealershipId = $request->id;

                if($this->dealershipCanCreateUser($dealershipId)){
                    return $next($request);
                }

                return $this->redirectForbidden();


            default:
//                return $this->redirectForbidden();
                dd($routeName);
        }
    }


    /**
     * @param $dealershipId
     * @param $eventId
     * @return bool
     */
    private function dealershipCanEditEvent($dealershipId, $eventId)
    {
        $event = Event::select('id')
            ->where([
                'dealership_id' => $dealershipId,
                'id' => $eventId
            ])->first();
        if($event){
            return true;
        }

        return false;
    }

    /**
     * @param $userId
     * @return bool
     */
    private function dealershipCanEditUser($userId)
    {
        $user = User::find($userId);
        $dealershipId = $this->authUser->dealership_id;
        // Check user exists
        if (!$user) {
            return false;
        }

        if ($user->dealership_id === $dealershipId) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param $dealershipId
     * @return bool
     */
    private function canEditDealership($dealershipId)
    {
        if ((int)$dealershipId === (int)$this->authUser->dealership_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Dealership can create user
     * @param $dealershipId
     * @return bool
     */
    private function dealershipCanCreateUser($dealershipId){
        if ((int)$dealershipId === (int)$this->authUser->dealership_id) {
            return true;
        } else {
            return false;
        }
    }

    private function redirectForbidden()
    {
        return redirect('/admin/dashboard??accessDenied=true');
    }
}
