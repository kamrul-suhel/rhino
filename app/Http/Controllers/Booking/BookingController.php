<?php

namespace App\Http\Controllers\Booking;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getData($eventId){
        $event = Event::findOrFail($eventId);
        return response()->json(
            [
                'event' => $event
            ]
        );
    }
}
