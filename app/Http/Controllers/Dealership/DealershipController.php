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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dealerships = Dealership::select(
            'dealerships.*',
            'dealerships_translation.name',
            'dealerships_translation.address_line_1',
            'dealerships_translation.address_line_2',
            'dealerships_translation.address_line_3',
            'dealerships_translation.address_line_4',
            'dealerships_translation.address_line_5',
            'dealerships_translation.address_line_6',
            'dealerships_translation.postcode',
            'groups_translation.name as group',
            'groups.logo as group_logo',
            'regions.name as region',
            'countries.name as country',
            'countries.capital as country_capital'
        )
            ->leftJoin('dealerships_translation', 'dealerships_translation.dealership_id', '=', 'dealerships.id')
            ->leftJoin('groups', 'groups.id', '=', 'dealerships.group_id')
            ->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id')
            ->leftJoin('regions', 'regions.id', '=', 'dealerships.region_id')
            ->leftJoin('countries', 'countries.id', '=', 'regions.country_id')
            ->where('dealerships_translation.language_id', $this->languageId)
            ->where('groups_translation.language_id', $this->languageId);

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $dealerships = $dealerships->where('dealerships_translation.name', 'LIKE', '%' . $request->search . '%');
            }

            // Get Only active country
            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case 'active':
                        $dealerships = $dealerships->where('status', 1);
                        break;

                    case 'inactive':
                        $dealerships = $dealerships->where('status', 0);
                        break;
                }
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                switch ($sortBy) {
                    case 'region':
                        $dealerships = $dealerships->orderBy('regions.name');
                        break;

                    case 'group':
                        $dealerships = $dealerships->orderBy('groups_translation.name');
                        break;

                    case 'country':
                        $dealerships = $dealerships->orderBy('countries.name');
                        break;
                }
            }else{
                $dealerships = $dealerships->orderBy('id', 'DESC');
            }
        }

        $dealerships = $dealerships->paginate($this->perPage);

        $totalDealerships = $dealerships->total();
        $dealerships = $dealerships->items();

        return response()->json(
            [
                'dealership' => $dealerships,
                'total' => $totalDealerships
            ]);
    }

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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dealership = Dealership::select(
            'dealerships.*',
            'dealerships_translation.name',
            'dealerships_translation.address_line_1',
            'dealerships_translation.address_line_2',
            'dealerships_translation.address_line_3',
            'dealerships_translation.address_line_4',
            'dealerships_translation.address_line_5',
            'dealerships_translation.address_line_6',
            'dealerships_translation.postcode',
            'groups_translation.name as group',
            'groups.logo as group_logo',
            'regions.name as region',
            'countries.name as country',
            'countries.id as country_id',
            'countries.capital as country_capital'
        )
            ->leftJoin('dealerships_translation', 'dealerships_translation.dealership_id', '=', 'dealerships.id')
            ->leftJoin('groups', 'groups.id', '=', 'dealerships.group_id')
            ->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id')
            ->leftJoin('regions', 'regions.id', '=', 'dealerships.region_id')
            ->leftJoin('countries', 'countries.id', '=', 'regions.country_id')
            ->where('dealerships_translation.language_id', $this->languageId)
            ->where('groups_translation.language_id', $this->languageId)
            ->where('dealerships.id',$id)
            ->first();

        $regions = [];
        if($dealership->country_id){
            $regions = Region::where('country_id', $dealership->country_id)
                ->get();
        }
        return response()->json([
            'dealership' => $dealership,
            'regions' => $regions
        ]);

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

    private function saveDealership(DealershipRequest $request, $dealershipId = null){
        $dealership = $dealershipId === null ? new Dealership() : Dealership::findOrFail($dealershipId);

        $request->has('latitude') ? $dealership->latitude = $request->latitude : null;
        $request->has('longitude') ? $dealership->longitude = $request->longitude : null;
        $request->has('group_id') ? $dealership->group_id = $request->group_id : null;
        $request->has('region_id') ? $dealership->region_id = $request->region_id : null;
        $request->has('saturday_start') && $request->saturday_start != 'null' ? $dealership->saturday_start = $request->saturday_start  : null;
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
        $request->has('friday_end') && $request->friday_end != 'null'? $dealership->friday_end = $request->friday_end : null;
        $request->has('status') ? $dealership->status = $request->status === 'true' ? 1: 0 : null;

        $dealership->save();

        // Save translation
        $dealershipTranslation = $dealershipId === null ? new DealershipTranslation() :
            DealershipTranslation::where([
                'dealership_id' => $dealership->id,
                'language_id' => $this->languageId
            ])->first();

        $dealershipTranslation->dealership_id = $dealership->id;
        $dealershipTranslation->language_id = $this->languageId;
        $request->has('address_line_1') ? $dealershipTranslation->address_line_1 = $request->address_line_1 : null;
        $request->has('address_line_2') ? $dealershipTranslation->address_line_2 = $request->address_line_2 : null;
        $request->has('address_line_3') ? $dealershipTranslation->address_line_3 = $request->address_line_3 : null;
        $request->has('address_line_4') ? $dealershipTranslation->address_line_4 = $request->address_line_4 : null;
        $request->has('address_line_5') ? $dealershipTranslation->address_line_5 = $request->address_line_5 : null;
        $request->has('address_line_6') ? $dealershipTranslation->address_line_6 = $request->address_line_6 : null;
        $request->has('name') ? $dealershipTranslation->name = $request->name : null;

        $dealershipTranslation->save();

        return true;
    }
}
