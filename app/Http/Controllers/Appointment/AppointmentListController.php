<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\EventUser;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, $eventId)
    {
        $users = EventUser::select('user_id')
            ->where('event_id', $eventId)
            ->pluck('user_id');

        $appointments = Appointment::select(
            'appointments.*',
            'guests.first_name as guest_first_name',
            'guests.surname as guest_surname'
        )->leftJoin('guests', 'appointments.guest_id', '=', 'guests.id');

        // If saleExecutive property exists in request, then only fetch record for specific sale executive
        if(
            $request->has('saleExecutiveId') &&
            !empty($request->saleExecutiveId)
        ){
            $appointments = $appointments->where('appointments.user_id', $request->saleExecutiveId);
        }

        // If request has date params, then load only specific date appointment
        if($request->has('date') && !empty($request->date)){
            $date = Carbon::parse($request->date);
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();
            $appointments = $appointments->whereBetween('appointments.start',[$startOfDay, $endOfDay]);
        }

        $appointments = $appointments->whereIn('appointments.status', [
            Appointment::APPOINTMENT_CONFIRMED,
            Appointment::APPOINTMENT_NOT_AVAILABLE,
            Appointment::APPOINTMENT_BREAK_TIME
        ]);

        $appointments = $appointments->where('appointments.event_id', $eventId)->get();

        return response()->json([
            'appointments' => $appointments,
            'total' => $appointments->count()
        ]);
    }
}
