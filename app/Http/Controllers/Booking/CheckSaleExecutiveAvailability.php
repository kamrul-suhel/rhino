<?php

namespace App\Http\Controllers\Booking;

use App\Appointment;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckSaleExecutiveAvailability extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request, $id)
    {
        $modifySlot = [];
        $saleExecutiveId = $request->saleExecutiveId;

        foreach ($request->slots as $slot) {
            $startTimeStart = Carbon::parse($slot['start']);
            $startTimeEnd = Carbon::parse($slot['end'])->sub('1 seconds');

            $endTimeStart = Carbon::parse($slot['start'])->add('1 seconds');
            $endTimeEnd = Carbon::parse($slot['end']);
            // check appointment table is this time is exists with sale executive
            $appointment = Appointment::where(function ($query) use ($startTimeStart, $startTimeEnd, $endTimeStart, $endTimeEnd, $saleExecutiveId) {
                $query->whereBetween('start', [$startTimeStart, $startTimeEnd])
                    ->orWhereBetween('end', [$endTimeStart, $endTimeEnd]);
            })->where('user_id', $saleExecutiveId)
                ->whereIn('status', [
                    Appointment::APPOINTMENT_CONFIRMED,
                    Appointment::APPOINTMENT_NOT_AVAILABLE,
                    Appointment::APPOINTMENT_BREAK_TIME
                ])
                ->first();

            if ($appointment) {
                $modifySlot[] = [
                    'slotId' => $slot['slotId'],
                    'start' => $slot['start'],
                    'end' => $slot['end'],
                    'status' => 'unavailable'
                ];
            } else {
                $modifySlot[] = [
                    'slotId' => $slot['slotId'],
                    'start' => $slot['start'],
                    'end' => $slot['end'],
                    'status' => 'available'
                ];
            }
        }

        return response()->json([
            'success' => true,
            'slots' => $modifySlot
        ]);
    }
}
