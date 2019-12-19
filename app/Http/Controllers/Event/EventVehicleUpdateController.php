<?php

namespace App\Http\Controllers\Event;

use App\EventVehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventVehicleUpdateController extends Controller
{
    public function update(Request $request, $eventVehicleId)
    {
        $eventVehicle = EventVehicle::findOrFail($eventVehicleId);

        $request->has('new') ? $eventVehicle->new = $request->new : null;
        $request->has('used') ? $eventVehicle->used = $request->used : null;
        $request->has('image') && $request->image != 'null' ? $eventVehicle->image = $request->image : null;
        $request->has('order') ? $eventVehicle->order = $request->order : null;

        $eventVehicle->save();

        return response()->json([
            'success' => true
        ]);
    }
}
