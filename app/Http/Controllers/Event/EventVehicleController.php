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
            'vehicles.brand_id',
            'vehicles_translation.language_id',
            'vehicles.driver_seating_position_left_image',
            'vehicles.driver_seating_position_right_image',
            'vehicles_translation.model'
        )->leftJoin('vehicles', function($vehicle){
            $vehicle->on('vehicles.id', '=', 'event_vehicle.vehicle_id');
            $vehicle->leftJoin('vehicles_translation', function($vehicleTranslation){
                $vehicleTranslation->on('vehicles_translation.vehicle_id', '=', 'vehicles.id');
                $vehicleTranslation->where('vehicles_translation.language_id', $this->languageId);
            });
        })
        ->where('event_vehicle.event_id', $request->id);

        // Filter by Vehicle type
        if($request->has('vehicleType') && !empty($request->vehicleType)){
            switch($request->vehicleType){
                case 'new':
                    $eventVehicles = $eventVehicles->where('event_vehicle.new', 1);
                    break;
                case 'used':
                    $eventVehicles = $eventVehicles->where('event_vehicle.used', 1);
                    break;
                default:
            }
        }

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
