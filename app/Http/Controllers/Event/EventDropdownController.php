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
    public function index(Request $request)
    {
        $events = Event::select(
            'events.*',
            'events_translation.name as event',
            'events_translation.name',
            'events_translation.language_id'
        )
            ->leftJoin('events_translation', function ($eventT) {
                $eventT->on('events_translation.event_id', '=', 'events.id');
                $eventT->where('events_translation.language_id', $this->languageId);

            })
            ->where('events.status', 1);

        if ($request->has('dealershipId') && !empty($request->dealershipId)) {
            $events = $events->where('events.dealership_id', $request->dealershipId);
            $events = $events->orderBy('events.start', 'DESC');
        }

        $events = $events->get();

        return response()->json([
            'events' => $events,
            'total' => $events->count()
        ]);
    }
}
