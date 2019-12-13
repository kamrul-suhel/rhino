<?php

namespace App\Http\Controllers\Event;

use App\EventVehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventVehicleController extends Controller
{
    /**
     * Display list of vehicles by event
     *
     * @return \Illuminate\Http\Response
     */
    public function getVehicleByEventId(Request $request)
    {
        $eventVehicles = EventVehicle::select(
            'event_vehicle.*',
            'vehicles_translation.language_id',
            'vehicles_translation.model'
        )->leftJoin('vehicles', function($vehicle){
            $vehicle->on('vehicles.id', '=', 'event_vehicle.vehicle_id');
            $vehicle->leftJoin('vehicles_translation', 'vehicles_translation.vehicle_id', '=', 'vehicles.id');
            $vehicle->where('vehicles_translation.language_id', $this->languageId);
        })
        ->where('event_vehicle.event_id', $request->id);


        // Filter Events if exists
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search by model
            if ($request->has('search') && !empty($request->search)) {
                $eventVehicles = $eventVehicles->where('vehicles_translation.model', 'LIKE', '%' . $request->search . '%');
            }

            $data = $eventVehicles->paginate($this->perPage);
            $totalEvent = $data->total();
            $data = $data->items();
        } else {
            $data = $eventVehicles->get();
            $totalEvent = $eventVehicles->count();
        }

        return response()->json([
           'vehicles' => $data,
           'total' => $totalEvent
        ]);
    }
}
