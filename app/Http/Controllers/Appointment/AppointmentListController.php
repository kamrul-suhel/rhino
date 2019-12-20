<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($eventId)
    {
        $appointments = Appointment::select(
            'appointments.*'
        )->where([
            'event_id' => $eventId
        ])->get();

        return response()->json([
            'appointments' => $appointments,
            'total' => $appointments->count()
        ]);
    }
}
