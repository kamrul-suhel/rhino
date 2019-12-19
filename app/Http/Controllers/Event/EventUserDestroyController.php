<?php

namespace App\Http\Controllers\Event;

use App\EventUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        ])->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
