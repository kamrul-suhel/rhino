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
            $startTime = Carbon::parse($slot['start'])->add('1 seconds');
            $endTime = Carbon::parse($slot['end']);
            // check appointment table is this time is exists with sale executive
            $appointment = Appointment::where(function ($query) use ($startTime, $endTime, $saleExecutiveId) {
                $query->whereBetween('start', [$startTime, $endTime])
                    ->orWhereBetween('end', [$startTime, $endTime]);
            })->where('user_id', $saleExecutiveId)
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
