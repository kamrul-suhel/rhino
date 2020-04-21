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
     * @param int $id
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
            ->with([
                'appointment.user',
                'appointment.vehicles' => function($appointmentV){
                    $appointmentV->select(
                        'appointment_vehicles.*',
                        'vehicles.*',
                        'vehicles_translation.model as vehicle_name'
                    );
                    $appointmentV->leftJoin('vehicles', function($vehicle){
                       $vehicle->on('vehicles.id', '=', 'appointment_vehicles.vehicle_id');
                       $vehicle->leftJoin('vehicles_translation', function($vehicleT){
                          $vehicleT->on('vehicles_translation.vehicle_id', '=', 'vehicles.id')
                          ->where('vehicles_translation.language_id', $this->languageId);
                       });
                    });
                },

                'appointment.event' => function ($event) {
                    $languageId = $this->languageId;
                    $event->select(
                        'events.*',
                        'events_translation.name as event_name',
                        'events_translation.notes as event_note'
                    )
                        ->leftJoin('events_translation', function ($eventT) use ($languageId) {
                            $eventT->on('events_translation.event_id', '=', 'events.id')
                                ->where('events_translation.language_id', $this->languageId);
                        });

                }
            ])
            ->where('guests.id', $id)
            ->first();

        return response()->json([
            'success' => true,
            'guest' => $guest
        ]);
    }
}
