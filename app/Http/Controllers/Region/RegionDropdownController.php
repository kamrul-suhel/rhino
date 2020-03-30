<?php

namespace App\Http\Controllers\Region;

use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Http\Request;

class RegionDropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegions(Request $request)
    {
        $data = [];

        $regions = Region::select(
            'regions.id',
            'regions.name'
        );

        if($request->has('countryId')){
            $regions = $regions->where('regions.country_id', $request->countryId);
        }

        $data = $regions->get();

        return response()->json(
            [
                'regions' => $data
            ]
        );
    }
}
