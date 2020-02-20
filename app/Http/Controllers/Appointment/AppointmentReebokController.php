<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentReebokController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reebok(Request $request)
    {
        DB::transaction(function() use($request){
            $guest = Guest::findOrFail($request->guest_id);
            $guest->status = 0; // Make status is pending, he did not complete guest journey
            $guest->save();

            $appointment = Appointment::findOrFail($request->appointment_id);
            $vehicles = $appointment->vehicles;

            // Replicate existing appointment
            $newAppointment = $appointment->replicate();
            $newAppointment->start = null;
            $newAppointment->end = null;
            $newAppointment->user_id = null;
            $newAppointment->slot_id = null;
            $newAppointment->status = 0; // pending
            $newAppointment->save();

            $vehicles->map(function($vehicle) use($newAppointment){
                // Replicate existing vehicle
                $newVehicle = $vehicle->replicate();
                $newVehicle->appointment_id = $newAppointment->id;
                $newVehicle->save();
            });
        });

        return response()->json([
            'success' => true
        ]);
    }

}
