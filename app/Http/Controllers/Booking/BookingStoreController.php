<?php

namespace App\Http\Controllers\Booking;

use App\Appointment;
use App\AppointmentVehicle;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;

class BookingStoreController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        $appointment = $this->save($request);
        if($appointment){
            return response()->json([
                'success' => true,
                'request' => $appointment
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function save(BookingRequest $request, $id = null)
    {
        $appointment = $id ? Appointment::findOrFail($id) : new Appointment();

        $request->has('event_id') ? $appointment->event_id = $request->event_id : null;
        $request->has('user_id') ? $appointment->user_id = $request->user_id : null;
        $request->has('guest_id') ? $appointment->guest_id = $request->guest_id : null;
        $request->has('slot_id') ? $appointment->slot_id = $request->slot_id : null;
        $request->has('bring_guest') && $request->bring_guest !== 'null' ? $appointment->bring_guest = $request->bring_guest : null;
        $request->has('guest_changing_car') && $request->guest_changing_car !== 'null' ? $appointment->guest_changing_car = $request->guest_changing_car : null;
        $request->has('start') ? $appointment->start = $request->start : null;
        $request->has('end') ? $appointment->end = $request->end : null;
        $request->has('part_ex_vrm') && $request->part_ex_vrm !== 'null' ? $appointment->part_ex_vrm = $request->part_ex_vrm : null;
        $request->has('part_ex_vehicle') && $request->part_ex_vehicle !== 'null' ? $appointment->part_ex_vehicle = $request->part_ex_vehicle : null;
        $request->has('part_ex_distance') && $request->part_ex_distance !== 'null' ? $appointment->part_ex_distance = $request->part_ex_distance : null;

        $appointment->save();

        // if vehicles exists then update vehicle
        if ($request->has('vehicles')
            && count($request->vehicles) > 0
        ) {
            foreach ($request->vehicles as $vehicle) {
                $appointmentVehicle = new AppointmentVehicle();
                $appointmentVehicle->appointment_id = $appointment->id;
                $appointmentVehicle->vehicle_id = $vehicle['id'];
                $appointmentVehicle->vehicle_condition = $vehicle['condition'];
                $appointmentVehicle->save();
            }
        }

        return $appointment;
    }
}
