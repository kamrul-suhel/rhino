<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
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
        }

        $appointment->save();
        return response()->json([
            'success' => true
        ]);
    }
}
