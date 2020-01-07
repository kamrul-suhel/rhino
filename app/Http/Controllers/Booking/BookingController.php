<?php

namespace App\Http\Controllers\Booking;

use App\Appointment;
use App\Brand;
use App\Dealership;
use App\Event;
use App\EventVehicle;
use App\Guest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getData($uniqueId){

        $guest = Guest::where('unique', $uniqueId)->first();
        $event = '';
        $dealership = '';
        $vehicles= [];
        $brands = [];

        if($guest){
            $event = Event::find($guest->event_id);
            $dealership = Dealership::select(
                'dealerships.*',
                'countries.driver_seating_position'
            )
                ->leftJoin('countries','countries.id', '=', 'dealerships.country_id' )
                ->where('dealerships.id', $event->dealership_id)
                ->first();

            $vehicles = EventVehicle::select(
                'event_vehicle.*',
                'vehicles_translation.model',
                'vehicles.driver_seating_position_left_image',
                'vehicles.driver_seating_position_right_image'
            )
                ->leftJoin('vehicles', function($vehicle){
                    $vehicle->on('vehicles.id', '=', 'event_vehicle.vehicle_id')
                        ->leftJoin('vehicles_translation', 'vehicles_translation.vehicle_id', 'vehicles.id')
                        ->where('vehicles_translation.language_id', $this->languageId);
                })
                ->where('event_id', $event->id)
                ->get();

            $brands = Brand::select(
                'brands.*'
            )->leftJoin('brand_event', 'brand_event.brand_id', '=', 'brands.id')
                ->leftJoin('events', 'events.id', '=', 'brand_event.event_id')
                ->where('events.id', $event->id)
                ->get();

            $saleExecutives = User::select(
                'users.*'
            )
                ->where('dealership_id', $dealership->id)
                ->get();

            $appointments = Appointment::select()
                ->where('appointments.event_id', $event->id)
                ->get();
        }

        return response()->json(
            [
                'guest' => $guest,
                'event' => $event,
                'dealership' => $dealership,
                'vehicles' => $vehicles,
                'brands' => $brands,
                'saleExecutives' => $saleExecutives,
                'appointments' => $appointments
            ]
        );
    }
}
