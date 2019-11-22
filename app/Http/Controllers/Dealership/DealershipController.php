<?php

namespace App\Http\Controllers\Dealership;

use App\Dealership;
use App\Http\Controllers\Controller;
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
        if($request->has('paginate') && !empty($request->paginate)){
            // Search dealership name
            if($request->has('search') && !empty($request->search)){
                $dealerships = $dealerships->where('dealerships_translation.name', 'LIKE', '%'.$request->search. '%');
            }

            // Get Only active country
            if($request->has('type') && !empty($request->type)){
                switch($request->type){
                    case 'active':
                        $dealerships = $dealerships->where('status', 1);
                        break;

                    case 'inactive':
                        $dealerships = $dealerships->where('status', 0);
                        break;
                }
            }

            // If sortBy has set then, sort by region, group, country
            if($request->has('sortBy') && !empty($request->sortBy)){
                $sortBy = $request->sortBy;
                switch($sortBy){
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
