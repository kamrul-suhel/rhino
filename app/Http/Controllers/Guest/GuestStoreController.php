<?php

namespace App\Http\Controllers\Guest;

use App\Guest;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuestRequest;
use Illuminate\Http\Request;

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
        $this->save($request);


       return response()->json([
           'success' => true
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

        // If creating new guest, then generate new unique id
        if(!$id){
            $guest->unique = generateUniqueIdForGuest();
        }

        $guest->save();

        return $guest;
    }

}
