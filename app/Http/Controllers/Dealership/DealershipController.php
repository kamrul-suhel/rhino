<?php

namespace App\Http\Controllers\Dealership;

use App\Dealership;
use App\DealershipTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealershipRequest;
use App\Region;
use Illuminate\Http\Request;

class DealershipController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealershipRequest $request)
    {
        $dealership = $this->saveDealership($request);
        return response()->json(['success' => true]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealershipRequest $request, $id)
    {
        $dealership = $this->saveDealership($request, $id);
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dealership = Dealership::findOrFail($id);
        $dealership->delete();
        return response()->json(['success' => true]);
    }

    private function saveDealership(DealershipRequest $request, $dealershipId = null)
    {
        $dealership = $dealershipId === null ? new Dealership() : Dealership::findOrFail($dealershipId);

        $request->has('latitude') ? $dealership->latitude = $request->latitude : null;
        $request->has('longitude') ? $dealership->longitude = $request->longitude : null;
        $request->has('group_id') && $request->group_id != 'null' ? $dealership->group_id = $request->group_id : null;
        $request->has('country_id') ? $dealership->country_id = $request->country_id : null;
        $request->has('saturday_start') && $request->saturday_start != 'null' ? $dealership->saturday_start = $request->saturday_start : null;
        $request->has('saturday_end') && $request->saturday_end != 'null' ? $dealership->saturday_end = $request->saturday_end : null;
        $request->has('sunday_start') && $request->sunday_start != 'null' ? $dealership->sunday_start = $request->sunday_start : null;
        $request->has('sunday_end') && $request->sunday_end != 'null' ? $dealership->sunday_end = $request->sunday_end : null;
        $request->has('monday_start') && $request->monday_start != 'null' ? $dealership->monday_start = $request->monday_start : null;
        $request->has('monday_end') && $request->monday_end != 'null' ? $dealership->monday_end = $request->monday_end : null;
        $request->has('thursday_start') && $request->thursday_start != 'null' ? $dealership->thursday_start = $request->thursday_start : null;
        $request->has('thursday_end') && $request->thursday_end != 'null' ? $dealership->thursday_end = $request->thursday_end : null;
        $request->has('tuesday_end') && $request->tuesday_end != 'null' ? $dealership->tuesday_end = $request->tuesday_end : null;
        $request->has('tuesday_start') && $request->tuesday_start != 'null' ? $dealership->tuesday_start = $request->tuesday_start : null;
        $request->has('wednesday_start') && $request->wednesday_start != 'null' ? $dealership->wednesday_start = $request->wednesday_start : null;
        $request->has('wednesday_end') && $request->wednesday_end != 'null' ? $dealership->wednesday_end = $request->wednesday_end : null;
        $request->has('friday_start') && $request->friday_start != 'null' ? $dealership->friday_start = $request->friday_start : null;
        $request->has('friday_end') && $request->friday_end != 'null' ? $dealership->friday_end = $request->friday_end : null;
        $request->has('suffix') && $request->suffix != 'null' ? $dealership->suffix = $request->suffix : null;
        $request->has('suffix') && $request->calendar_access != 'null' ? $dealership->calendar_access = $request->calendar_access : null;
        $request->has('suffix') && $request->enable_emails != 'null' ? $dealership->enable_emails = $request->enable_emails : null;
        $request->has('status') ? $dealership->status = $request->status : null;

        $dealership->save();

        // Save translation
        $dealershipTranslation = $dealershipId === null ? new DealershipTranslation() :
            DealershipTranslation::where([
                'dealership_id' => $dealership->id,
                'language_id' => $this->languageId
            ])->first();

        $dealershipTranslation->dealership_id = $dealership->id;
        $dealershipTranslation->language_id = $this->languageId;
        $request->has('address_line_1') && $request->address_line_1 != 'null' ? $dealershipTranslation->address_line_1 = $request->address_line_1 : null;
        $request->has('address_line_2') && $request->address_line_2 != 'null' ? $dealershipTranslation->address_line_2 = $request->address_line_2 : null;
        $request->has('address_line_3') && $request->address_line_3 != 'null' ? $dealershipTranslation->address_line_3 = $request->address_line_3 : null;
        $request->has('address_line_4') && $request->address_line_4 != 'null' ? $dealershipTranslation->address_line_4 = $request->address_line_4 : null;
        $request->has('address_line_5') && $request->address_line_5 != 'null'? $dealershipTranslation->address_line_5 = $request->address_line_5 : null;
        $request->has('address_line_6') && $request->address_line_6 != 'null'? $dealershipTranslation->address_line_6 = $request->address_line_6 : null;
        $request->has('name') ? $dealershipTranslation->name = $request->name : null;

        $dealershipTranslation->save();

        return true;
    }
}
