<?php

namespace App\Http\Controllers\Event;

use App\Event;
use App\EventTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventShowController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id){

        if(
            $request->has('edit') &&
            !empty($request->edit)
        ){
            $eventTranslation = EventTranslation::where([
                'event_id'=> $id,
                'language_id' =>$this->languageId
            ])->first();

            if(!$eventTranslation){
                $eventTranslation = new EventTranslation();
                $eventTranslation->language_id = $this->languageId;
                $eventTranslation->event_id = $id;
                $eventTranslation->save();
            }
        }


        $event = Event::select(
            'events.*',
            'events_translation.name',
            'events_translation.notes',
            'events_translation.language_id',
            'dealerships.id as dealership_id',
            'dealerships.country_id',
            'dealerships_translation.name as dealership',
            'countries.driver_seating_position as country_driver_seating_position',
            'countries.name as country',

            'types.id as type_id',
            'types_translation.name as type'
        )
            ->leftJoin('events_translation', function($eventT){
                $eventT->on('events_translation.event_id', '=', 'events.id');
                $eventT->where('events_translation.language_id', $this->languageId);

            })

            // Join event type table
            ->leftJoin('types', function($type){
                $type->on('types.id', '=', 'events.type_id');
                $type->leftJoin('types_translation', function($typeT){
                    $typeT->on('types_translation.type_id', '=', 'types.id');
                    $typeT->where('types_translation.language_id', $this->languageId);
                });
            })

            ->leftJoin('dealerships', function($dealership){
                $dealership->on('dealerships.id', '=', 'events.dealership_id');
                $dealership->leftJoin('dealerships_translation', 'dealerships_translation.dealership_id', '=', 'dealerships.id');
                $dealership->leftJoin('countries', 'dealerships.country_id', '=', 'countries.id');
                $dealership->where('dealerships_translation.language_id', $this->languageId);
            })
            ->where('events_translation.language_id', $this->languageId)
            ->where('events.id', $id)
            ->first();

        return response()->json([
            'event' => $event
        ]);
    }
}
