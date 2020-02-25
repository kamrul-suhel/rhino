<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\DealershipUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDeleteController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $user = User::with('dealerships')->where('id', $id)->first();

        DealershipUser::where('user_id', $user->id)->delete();
        $user->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
