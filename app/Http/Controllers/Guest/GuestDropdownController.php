<?php

namespace App\Http\Controllers\Guest;

use App\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestDropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $guests = Guest::select(
            'id',
            'first_name',
            'unique',
            'surname',
            'mobile',
            DB::raw("CONCAT(surname,' ', first_name) as name"),
            'email',
            'event_id',
            'postcode'
        );

        if ($request->has('search') && !empty($request->search)) {
            $guests = $guests->where(function ($guest) use ($request) {
                $guest->where('guests.email', 'like', '%' . $request->search . '%')
                    ->orWhere('guests.first_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('guests.surname', 'LIKE', '%' . $request->search . '%');
            });
        }
        // If request has eventId, then load specific event guest.
        if ($request->has('eventId') && !empty($request->eventId)) {
            $guests = $guests->where('event_id', '=', $request->eventId);
        }

        $data = $guests->get();
        $totalGuest = $guests->count();
        return response()->json([
            'guests' => $data,
            'total' => $totalGuest
        ]);
    }
}
