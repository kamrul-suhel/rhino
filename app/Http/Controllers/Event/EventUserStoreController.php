<?php

namespace App\Http\Controllers\Event;

use App\EventUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventUserStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     * Add relation between event & user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eventUser = new EventUser();
        $eventUser->event_id = $request->event_id;
        $eventUser->user_id = $request->user_id;
        $eventUser->save();

        return response()->json([
            'success' => true,
            'data' => $eventUser
        ]);
    }
}
