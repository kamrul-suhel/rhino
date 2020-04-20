<?php

namespace App\Http\Controllers\Event;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $totalEvent = 0;
        $events = Event::select(
            'events.*',
            'events_translation.name as event',
            'events_translation.language_id',
            'dealerships.id as dealership_id',
            'dealerships.country_id',
            'dealerships_translation.name as dealership',
            'countries.driver_seating_position as country_driver_seating_position',
            'countries_translation.name as country',

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
                $dealership->leftJoin('countries', function($country){
                    $country->on('dealerships.country_id', '=', 'countries.id')
                        ->leftJoin('countries_translation', function($countryT){
                           $countryT->on('countries_translation.country_id', '=', 'countries.id')
                           ->where('countries_translation.language_id', '=', $this->languageId);
                        });
                });
                $dealership->where('dealerships_translation.language_id', $this->languageId);
            })
            ->where('events_translation.language_id', $this->languageId);

        // Filter Events if exists
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $events = $events->where('events_translation.name', 'LIKE', '%' . $request->search . '%');
            }

            // Get Only active country
            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case 'active':
                        $events = $events->where('events.status', 1);
                        break;

                    case 'inactive':
                        $events = $events->where('events.status', 0);
                        break;
                }
            }

            if($request->has('filterBy') && !empty($request->filterBy)){
                switch($request->filterBy){
                    case 'dealership':
                        $events = $events->where('dealerships.id', $request->dealershipId);
                        break;
                }
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                switch ($sortBy) {
                    case 'name':
                        $events = $events->orderBy('events_translation.name');
                        break;

                    case 'status':
                        $events = $events->orderBy('events.status', 'DESC');
                        break;
                }
            } else {
                $events = $events->orderBy('events.id', 'DESC');
            }

            $data = $events->paginate($this->perPage);
            $totalEvent = $data->total();
            $data = $data->items();
        } else {
            $data = $events->get();
            $totalEvent = $events->count();
        }

        return response()->json([
            'events' => $data,
            'total' => $totalEvent
        ]);
    }
}
