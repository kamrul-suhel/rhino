<?php

namespace App\Http\Controllers\Event;

use App\EventVehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventVehicleDestroyController extends Controller
{
    /**
     * Delete relation between event & vehicle
     * @param $eventVehicleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($eventVehicleId){
        $eventVehicle = EventVehicle::findOrFail($eventVehicleId);
        $eventVehicle->delete();

        return response()->json([
           'success' => true
        ]);
    }
}
