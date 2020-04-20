<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            // validation is failed
        }

        $user = $this->save($request);
        return response()->json([
            'success'   => true,
            'user'      => $user
        ]);

    }

    /**
     * @param Request $request
     * @param $userId
     */
    public function update(Request $request, $userId){
        $user = $this->save($request, $userId);
    }

    /**
     * @param Request $request
     * @param '' $id
     * @return mixed
     */
    protected function save(Request $request, $id = null){
        $user = $id ? User::findOrFail($id) : new User() ;
        $request->has('firstname') ? $user->firstname = $request->firstname : '';
        $request->has('surname') ? $user->surname = $request->surname : '';
        $request->has('email') ? $user->email = $request->email : '';
        $request->has('password') ? $user->password = Hash::make($request->password) : '';
        $request->has('level') ? $user->level = $request->level : '';
        $request->has('status') ? $user->status = $request->status : '';
        $request->has('profile_image') ? $user->profile_image = $request->profile_image : '';
        $request->has('notes') ? $user->notes = $request->notes : '';

        $user = $this->updateUserLevel($user, $request);

        $user->save();

        if(
            $request->has('dealershipId') &&
            !empty($request->dealershipId)
        ){
            $user->dealerships()->attach([$request->dealershipId]);
        }

        return $user;
    }

    /**
     * @param $user
     * @param $request
     * @return mixed
     */
    protected function updateUserLevel($user, $request){
        switch($request->level){
            case User::USERADMIN:
                $user->dealership_id = null;
                $user->group_id = null;
                $user->region_id = null;
                $user->country_id = null;
                $user->manufacturer_id = null;
                $user->company_id = null;
                break;

            case User::USERDEALERSHIP:
                $user->dealership_id = $request->dealershipId;
                $user->group_id = $request->has('group_id') ? $request->group_id : null;
                $user->region_id = $request->has('region_id') ? $request->region_id : null;
                $user->country_id = $request->has('country_id') ? $request->country_id : null;
                $user->manufacturer_id = null;
                $user->company_id = null;
                break;

            case User::USERSALEEXECUTIVE:
                $user->dealership_id = $request->dealershipId;
                $user->group_id = $request->has('group_id') ? $request->group_id : null;
                $user->region_id = $request->has('region_id') ? $request->region_id : null;
                $user->country_id = $request->has('country_id') ? $request->country_id : null;
                $user->manufacturer_id = null;
                $user->company_id = null;
                break;

            case User::USERGROUP:
                $user->dealership_id = null;
                $user->group_id = $request->group_id;
                $user->region_id = null;
                $user->country_id = null;
                $user->manufacturer_id = null;
                $user->company_id = null;
                break;

            case User::USERREGION:
                $user->dealership_id = null;
                $user->group_id = null;
                $user->region_id = $request->region_id;
                $user->country_id = $request->country_id;
                $user->manufacturer_id = $request->brand_id;
                $user->company_id = null;
                break;

            case User::USERRCOUNTRY:
                $user->dealership_id = null;
                $user->group_id = null;
                $user->region_id = null;
                $user->country_id = $request->country_id;
                $user->manufacturer_id = $request->has('brand_id') ? $request->brand_id : null;
                $user->company_id = null;
                break;

            case User::USERBRAND:
                $user->dealership_id = null;
                $user->group_id = null;
                $user->region_id = null;
                $user->country_id = null;
                $user->manufacturer_id = $request->brand_id;
                $user->company_id = null;
                break;

            case User::USERCOMPANY:
                $user->dealership_id = null;
                $user->group_id = null;
                $user->region_id = null;
                $user->country_id = null;
                $user->manufacturer_id = null;
                $user->company_id = $request->company_id;
                break;

            case User::USERRECEPTIONIST:
                $user->dealership_id = $request->dealershipId;
                $user->group_id = null;
                $user->region_id = null;
                $user->country_id = null;
                $user->manufacturer_id = null;
                $user->company_id = null;
                break;

            case User::USERCALLHANDLER:
                $user->dealership_id = $request->dealershipId;
                $user->group_id = null;
                $user->region_id = null;
                $user->country_id = null;
                $user->manufacturer_id = null;
                $user->company_id = null;
                break;
        }

        return $user;
    }
}
