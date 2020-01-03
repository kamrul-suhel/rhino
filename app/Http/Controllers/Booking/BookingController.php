<?php

namespace App\Http\Controllers\Booking;

use App\Dealership;
use App\Event;
use App\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getData($uniqueId){

        $guest = Guest::where('unique', $uniqueId)->first();
        $event = '';
        $dealership = '';

        if($guest){
            $event = Event::find($guest->event_id);
            $dealership = Dealership::find($event->dealership_id);
        }

        return response()->json(
            [
                'guest' => $guest,
                'event' => $event,
                'dealership' => $dealership
            ]
        );
    }
}
