<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentDestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $delete = $appointment->delete();

        if($delete){
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }
}
