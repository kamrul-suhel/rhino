<?php

namespace App\Http\Controllers\Country;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::select(
            'id',
            'full_name',
            'capital',
            'iso_3166_2',
            'driver_seating_position',
            'status',
            'flag'
        );
        // To get the list view populate
        if($request->has('paginate') && !empty($request->paginate)){
            // Search by name
            if($request->has('search') && !empty($request->search)){
                $countries = $countries->where('full_name', 'LIKE', '%'.$request->search.'%');
            }

            // Get Only active country
            if($request->has('type') && !empty($request->type)){
                switch($request->type){
                    case 'active':
                        $countries = $countries->where('status', 1);
                        break;

                    case 'inactive':
                        $countries = $countries->where('status', 0);
                        break;
                }
            }

            $countries = $countries->paginate($this->perPage);
            $data = $countries->items();
            $total = $countries->total();


            return response()->json([
                'data' => $data,
                'total' => $total
            ]);
        }
        $countries = $countries->get();

        return response()->json($countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO Need to implement latter, reason all the country will generate from seed.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::find($id);
        return response()->json($country);
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
        $country = Country::findOrFail($id);

        $request->has('name') ? $country->name = $request->name : null;
        $request->has('capital') ? $country->capital = $request->capital : null;
        $request->has('citizenship') ? $country->citizenship = $request->citizenship : null;
        $request->has('country_code') ? $country->country_code = $request->country_code : null;
        $request->has('currency') ? $country->currency = $request->currency : null;
        $request->has('currency_code') ? $country->currency_code = $request->currency_code : null;
        $request->has('currency_sub_unit') ? $country->currency_sub_unit = $request->currency_sub_unit : null;
        $request->has('full_name') ? $country->full_name = $request->full_name : null;
        $request->has('iso_3166_2') ? $country->iso_3166_2 = $request->iso_3166_2 : null;
        $request->has('iso_3166_3') ? $country->iso_3166_3 = $request->iso_3166_3 : null;
        $request->has('region_code') ? $country->region_code = $request->region_code : null;
        $request->has('sub_region_code') ? $country->sub_region_code = $request->sub_region_code : null;
        $request->has('eea') ? $country->eea = $request->eea : null;
        $request->has('calling_code') ? $country->calling_code = $request->calling_code : null;
        $request->has('currency_symbol') ? $country->currency_symbol = $request->currency_symbol : null;
        $request->has('flag') ? $country->flag = $request->flag : null;
        $request->has('driver_seating_position') ? $country->driver_seating_position = $request->driver_seating_position : null;
        $request->has('status') ? $country->status = $request->status : null;

        // Save country
        $country->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return response()->json(['success' => true]);
    }
}
