<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if($request->ajax()){
                return response()->json([
                    'success' => true,
                    'authUser' => Auth::user()
                ]);
            }else{
                return redirect()->intended('dashboard');
            }
        }
    }

    /**
     * Get Login user
     * @return mixed
     */
    public function getLoginUser(){
        $user = Auth::user();
        if($user){
            return response()->josn([
                'success' => true,
                'authUser' => $user
            ]);
        }
        
        return response()->json([
            'success' => false
        ]);
    }
}
