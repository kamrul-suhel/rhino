<?php

namespace App\Http\Controllers\Guest;

use App\Guest;
use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadGuestRequest;
use Illuminate\Http\Request;

class GuestDownloadCSVController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function download(DownloadGuestRequest $request)
    {
        $guests = Guest::select(
            'guests.*',
            'guests.status as guest_status',
            'appointments.*',
            'appointments.status as appointment_status'
        )
            ->leftJoin('appointments', 'guests.id', '=', 'appointments.guest_id')
            ->where('guests.event_id', $request->eventId);

        switch ($request->downloadType) {
            case 'bookedGuests':
                $guests = $guests->where([
                    'guests.status' => 1
                ]);
                break;

            case 'unbookedGuests':
                $guests = $guests->whereIn('guests.status', [6, 0]);
                break;
        }

        $guests = $guests->groupBy('guests.id')
            ->get();

        return response()->json([
            'success' => true,
            'guests' => $guests
        ]);
    }
}
