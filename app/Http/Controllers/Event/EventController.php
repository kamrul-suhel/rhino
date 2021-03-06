<?php

namespace App\Http\Controllers\Event;

use App\Event;
use App\EventTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = $this->save($request);

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event = $this->save($request, $id);

        return response()->json([
            'success' => $event
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'success' => true
        ]);
    }

    private function save(EventRequest $request, $id = null){
        $event = $id ? Event::findOrFail($id) : new Event();

        $request->has('dealership_id') ? $event->dealership_id = $request->dealership_id : null;
        $request->has('type_id') ? $event->type_id = $request->type_id : null;
        $request->has('start') ? $event->start = $request->start : null;
        $request->has('end') ? $event->end = $request->end : null;
        $request->has('appointment_duration') ? $event->appointment_duration = $request->appointment_duration : null;
        $request->has('banner_image') ? $event->banner_image = $request->banner_image : null;
        $request->has('break_time') ? $event->break_time = $request->break_time : null;
        $request->has('greeting') ? $event->greeting = $request->greeting : null;
        $request->has('status') ? $event->status = $request->status : null;

        $event->save();

        // Create or update Event translation
        if($id){
            $eventTranslation = EventTranslation::where([
                'event_id' => $event->id,
                'language_id' => $this->languageId
            ])->first();
        }else{
            $eventTranslation = new EventTranslation();
        }

        $eventTranslation->event_id = $event->id;
        $eventTranslation->language_id = $this->languageId;

        $request->has('name') ? $eventTranslation->name = $request->name : null;
        $request->has('notes') ? $eventTranslation->notes = $request->notes : null;

        $eventTranslation->save();

        return $event;
    }
}
