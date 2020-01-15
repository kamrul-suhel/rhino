<?php

namespace App\Http\Controllers\Event;

use App\BrandEvent;
use App\EventVehicle;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;

class EventBrandController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addBrand(Request $request, $eventId)
    {
        $eventId = $request->event_id;
        $brandId = $request->brand_id;

        // Populate bran_event table
        $brandEvent = new BrandEvent();
        $brandEvent->brand_id = $brandId;
        $brandEvent->event_id = $eventId;
        $brandEvent->save();

        // Get all vehicle by brand id
        $vehicles = Vehicle::where('brand_id', $brandId)
            ->get();

        $vehicles->map(function ($vehicle) use ($eventId) {
            // Generate Event vehicle table
            $eventVehicle = new EventVehicle();
            $eventVehicle->event_id = $eventId;
            $eventVehicle->vehicle_id = $vehicle->id;
            $eventVehicle->new = 1; // Default value
            $eventVehicle->used = 1; // Default value
            $eventVehicle->order = 0; // Default order none
            $eventVehicle->save();
        });

        return response()->json([
            'success' => true
        ]);
    }

    public function destroyBrand($eventId, $brandId)
    {
        $brandEvent = BrandEvent::where([
            'event_id' => $eventId,
            'brand_id' => $brandId
        ])->first();

        $brandEvent->delete();

        // Get all vehicle by brand id
        $vehicles = Vehicle::where('brand_id', $brandId)
            ->get();

        $vehicles->map(function ($vehicle) use ($eventId) {
            // Generate Event vehicle table
            EventVehicle::where([
                'event_id' => $eventId,
                'vehicle_id' => $vehicle->id
            ])->delete();
        });

        return response()->json([
            'success' => true
        ]);
    }
}
