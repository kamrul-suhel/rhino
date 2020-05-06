<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use App\Appointment;
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

        
        if ( $user->level == "sales_executive"){
    
            // check sales exec has no upcoming appointments
            $date = Carbon::today();      
            $userAppointments = Appointment::where('user_id', $user->id)->where('start', '>', $date)->get();

            if (count($userAppointments) > 0 ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales Exec has booked appointments'
                ]);                
            }


        }

        DealershipUser::where('user_id', $user->id)->delete();
        $user->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
