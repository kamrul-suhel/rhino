<?php

namespace App\Http\Controllers\Auth;

use App\Dealership;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dealership\DealershipController;
use App\Http\Controllers\Dealership\DealershipShowController;
use App\Http\Controllers\Event\EventBrandController;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:api')->except(['login', 'getLoginUser','logout']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if($request->ajax()){
                $token = auth('api')->attempt($credentials);
                return response()->json([
                    'success' => true,
                    'authUser' => Auth::user(),
                    'token' => $token
                ]);
            }else{
                return redirect()->intended('dashboard');
            }
        }

        return response()->json([
            'success' => false
        ]);
    }

    /**
     * Get Login user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoginUser(Request $request){
        $user = Auth::user();

        if($user){
            // Generate Token for api route.
            $token = auth('api')->tokenById($user->id);

            // If login user is dealership manager, then add dealership
            $dealership = null;
            $dealershipRegions = null;
            $brands = null;
            if(
                $user->level === User::USERDEALERSHIP &&
                !empty($user->dealership_id) ||
                $user->level === User::USERSALEEXECUTIVE
            )
            {
                $dealershipController = new DealershipShowController($request);
                $dealership = $dealershipController->show($request, $user->dealership_id, true);
            }

            return response()->json([
                'success' => true,
                'authUser' => $user,
                'dealership' => $dealership['dealership'],
                'regions' => $dealership['regions'],
                'token' => $token
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        if($request->ajax()){
            return response()->json([
                'success' => true
            ]);
        }

        return $this->loggedOut($request) ?: redirect('/admin');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
