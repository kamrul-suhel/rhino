<?php

namespace App\Http\Controllers\Event;

use App\EventUser;
use Carbon\Carbon;
use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventUserDestroyController extends Controller
{
    /**
     * Delete event user
     * @param $userId
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($eventId, $userId){

        $eventUser = EventUser::where([
            'event_id'=> $eventId,
            'user_id' => $userId
        ]);
        
        // check if sales exec has appointments
        // check sales exec has no upcoming appointments
        $date = Carbon::today();      
        $userAppointments = Appointment::where('user_id', $userId)->where('start', '>', $date)->get();

        if (count($userAppointments) > 0 ) {            
            return response()->json([
                'success' => false,
                'message' => 'Sales Exec has booked appointments'
            ]);                
        }

        $eventUser->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
