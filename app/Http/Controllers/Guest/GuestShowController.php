<?php

namespace App\Http\Controllers\Guest;

use App\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestShowController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guest = Guest::select(
            'guests.*',
            'events_translation.name as event'
        )
            ->leftJoin('events', function ($eventT) {
                $eventT->on('events.id', '=', 'guests.event_id');
                $eventT->leftJoin('events_translation', 'events_translation.event_id', 'events.id');
                $eventT->where('events_translation.language_id', $this->languageId);
            })
            ->where('guests.id', $id)
            ->first();

        return response()->json([
            'guest' => $guest
        ]);
    }
}
