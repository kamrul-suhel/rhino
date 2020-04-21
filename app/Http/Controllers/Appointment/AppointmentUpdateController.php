<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentUpdateController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        switch($request->type){
            case 'scheduleUpdate':
                $request->has('scheduleStart') ? $appointment->scheduled_start = $request->scheduleStart : '';
                $request->has('scheduleEnd') ? $appointment->scheduled_end = $request->scheduleEnd : '';
                break;

            case 'updateByGuest': // When guest try to update there appointment
                // First get guest and make his status pending
                $guest = Guest::findOrFail($appointment->guest_id);
                $guest->status = Guest::STATUS_PENDING;
                $guest->save();

                // Remove existing appointment time
                $appointment->start = NULL;
                $appointment->end = NULL;
                $appointment->user_id = NULL;
                $appointment->scheduled_start = NULL;
                $appointment->scheduled_end = NULL;
                $appointment->status = Appointment::APPOINTMENT_PENDING;
                break;
        }

        $appointment->save();
        return response()->json([
            'success' => true
        ]);
    }
}
