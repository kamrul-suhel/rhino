<?php

namespace App\Http\Controllers\Guest;

use App\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $data = [];
        $totalGuest = 0;
        $guests = Guest::select(
            'guests.*',
            'events_translation.name as event'
        )
            ->leftJoin('events', function ($eventT) {
                $eventT->on('events.id', '=', 'guests.event_id');
                $eventT->leftJoin('events_translation', 'events_translation.event_id', 'events.id');
                $eventT->where('events_translation.language_id', $this->languageId);
            });

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $guests = $guests->where('guests.first_name', 'LIKE', '%' . $request->search . '%');
            }

            // Get Only active country
            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case 'active':
                        $guests = $guests->where('status', 1);
                        break;

                    case 'inactive':
                        $guests = $guests->where('status', 0);
                        break;
                }
            }

            // If request has eventId, then load specific guest.
            if($request->has('eventId') & !empty($request->eventId)){
                $guests = $guests->where('guests.event_id', $request->eventId);
            }

            // If sortBy set, then sort by name
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                switch ($sortBy) {
                    case 'name':
                        $guests = $guests->orderBy('guests.first_name');
                        break;

                }
            } else {
                $guests = $guests->orderBy('guests.id', 'DESC');
            }

            $data = $guests->paginate($this->perPage);
            $totalGuest = $data->total();
            $data = $data->items();
        } else {
            $data = $guests->get();
            $totalBrand = $guests->count();
        }

        return response()->json([
            'guests' => $data,
            'total' => $totalGuest
        ]);
    }
}
