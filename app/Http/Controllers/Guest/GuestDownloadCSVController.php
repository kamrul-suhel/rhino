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
            'appointments.*'
        )
            ->leftJoin('appointments', 'guests.id', '=', 'appointments.guest_id')
            ->where('guests.event_id', $request->eventId);

        switch ($request->downloadType) {
            case 'bookedGuest':
                $guests = $guests->where('appointments.event_id', $request->eventId);
                break;
            case 'unbookedGuest':
                $guests = $guests->whereNull('appointments.event_id');
                break;
        }

        $guests = $guests->get();

        return response()->json([
            'success' => true,
            'guests' => $guests
        ]);
    }
}
