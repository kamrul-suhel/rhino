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
    public function getData($uniqueId)
    {

        $guest = Guest::with(['appointment' => function ($appointment) {
            $appointment->with('vehicles');
            $appointment->orderBy('id', 'DESC')
                ->first();
        }])
            ->where('unique', $uniqueId)
            ->first();

        $event = '';
        $dealership = '';
        $vehicles = [];
        $brands = [];

        if ($guest) {
            $event = Event::select(
                'events.*',
                'events_translation.name',
                'events_translation.notes'
            )
                ->leftJoin('events_translation', function ($eventT) {
                    $eventT->on('events_translation.event_id', '=', 'events.id')
                        ->where('events_translation.language_id', $this->languageId);
                })
                ->where('events.id', $guest->event_id)
                ->first();

            $dealership = Dealership::select(
                'dealerships.*',
                'countries.driver_seating_position'
            )
                ->leftJoin('countries', 'countries.id', '=', 'dealerships.country_id')
                ->where('dealerships.id', $event->dealership_id)
                ->first();

            $vehicles = EventVehicle::select(
                'event_vehicle.*',
                'vehicles.brand_id',
                'vehicles_translation.model',
                'vehicles.driver_seating_position_left_image',
                'vehicles.driver_seating_position_right_image'
            )
                ->leftJoin('vehicles', function ($vehicle) {
                    $vehicle->on('vehicles.id', '=', 'event_vehicle.vehicle_id')
                        ->leftJoin('vehicles_translation', function ($vehicleT) {
                            $vehicleT->on('vehicles_translation.vehicle_id', 'vehicles.id')
                                ->where('vehicles_translation.language_id', $this->languageId);
                        });

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
                'users.*',
                'event_user.user_id',
                'event_user.event_id'
            )
                ->leftJoin('event_user', 'event_user.user_id', '=', 'users.id')
                ->where('event_user.event_id', $event->id)
                ->with('specializeBrands')
                ->where('users.dealership_id', $dealership->id)
                ->get();

            $appointments = Appointment::where('appointments.event_id', $event->id)
                ->whereIn('appointments.status', [1, 3])
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
