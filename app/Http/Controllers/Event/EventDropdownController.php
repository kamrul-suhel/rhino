<?php

namespace App\Http\Controllers\Event;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventDropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::select(
            'events.*',
            'events_translation.name as event',
            'events_translation.language_id'
        )
            ->leftJoin('events_translation', function($eventT){
                $eventT->on('events_translation.event_id', '=', 'events.id');
                $eventT->where('events_translation.language_id', $this->languageId);

            })
            ->where('events.status', 1)
            ->get();

        return response()->json([
            'events' => $events,
            'total' => $events->count()
        ]);
    }
}
