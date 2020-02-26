<?php

namespace App\Http\Controllers\Guest;

use App\Event;
use App\Guest;
use App\Dealership;
use Illuminate\Http\Request;
use App\Http\Requests\GuestRequest;
use App\Http\Controllers\Controller;

class GuestStoreController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param GuestRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GuestRequest $request)
    {
        $guest = $this->save($request);

       return response()->json([
           'success' => true,
           'guest' => $guest
       ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GuestRequest $request, $id){
        $guest = $this->save($request, $id);

        if($guest){
            return response()->json([
                'success' => true
            ]);
        }
    }

    protected function save(GuestRequest $request, $id = null){
        $guest = $id ? Guest::findOrFail($id) : new Guest();

        $request->has('event_id') ? $guest->event_id = $request->event_id : null;
        $request->has('first_name') ? $guest->first_name = $request->first_name : null;
        $request->has('surname') ? $guest->surname = $request->surname : null;
        $request->has('email') ? $guest->email = $request->email : null;
        $request->has('address_line_1') ? $guest->address_line_1 = $request->address_line_1 : null;
        $request->has('address_line_2') ? $guest->address_line_2 = $request->address_line_2 : null;
        $request->has('address_line_3') ? $guest->address_line_3 = $request->address_line_3 : null;
        $request->has('address_line_4') ? $guest->address_line_4 = $request->address_line_4 : null;
        $request->has('address_line_5') ? $guest->address_line_5 = $request->address_line_5 : null;
        $request->has('address_line_6') ? $guest->address_line_6 = $request->address_line_6 : null;
        $request->has('postcode') ? $guest->postcode = $request->postcode : null;
        $request->has('landline') ? $guest->landline = $request->landline : null;
        $request->has('mobile') ? $guest->mobile = $request->mobile : null;
        $request->has('method') ? $guest->method = $request->{'method'} : null;
        $request->has('stage') ? $guest->stage = $request->stage : null;
        $request->has('status') ? $guest->status = $request->status : null;

        $request->has('postal_contact') ? $guest->postal_contact = $request->postal_contact : null;
        $request->has('email_contact') ? $guest->email_contact = $request->email_contact : null;
        $request->has('sms_contact') ? $guest->sms_contact = $request->sms_contact : null;
        $request->has('phone_contact') ? $guest->phone_contact = $request->phone_contact : null;
        $request->has('salutation') ? $guest->salutation = $request->salutation : null;

        // Set default language based on event default language
        $event = Event::find($request->event_id);
        if(
            $event->default_language_id !== 0 &&
            $event->default_language_id !== null
        ){
            $guest->language_id = $event->default_language_id;
        }

        // If creating new guest, then generate new unique id
        if(!$id){
            // Get code suffix from dealership
            $dealershipId = Event::where('id', $request->event_id)->pluck('dealership_id');
            $suffix = Dealership::where('id', $dealershipId)->pluck('suffix');
            $guest->unique = generateUniqueIdForGuest($suffix[0]);
        }

        $guest->save();

        return $guest;
    }

}
