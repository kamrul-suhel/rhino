<?php

namespace App\Http\Controllers\Dealership;

use App\Dealership;
use App\DealershipTranslation;
use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Http\Request;

class DealershipShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id, $isEvent = false)
    {
        // Create translation if not exists
        if($request->has('edit') && !empty($request->edit)){
            DealershipTranslation::firstOrCreate([
                'language_id' => $this->languageId,
                'dealership_id' => $id
            ],[
                'address_line_1' => '',
                'address_line_2' => '',
                'address_line_3' => '',
                'address_line_4' => '',
                'address_line_5' => '',
                'address_line_6' => '',
                'postcode' => '',
            ]);
        }


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
            'dealerships_translation.language_id',
            'groups_translation.name as group',
            'groups.logo as group_logo',
            'countries.name as country',
            'countries.id as country_id'
        )
            ->leftJoin('dealerships_translation', function($dealershipTranslation){
                $dealershipTranslation->on('dealerships_translation.dealership_id', '=', 'dealerships.id');
                $dealershipTranslation->where('dealerships_translation.language_id', $this->languageId);
            })
            ->leftJoin('groups', function ($group) {
                $group->on('groups.id', '=', 'dealerships.group_id');
                $group->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id');
                $group->where('groups_translation.language_id', '=', $this->languageId);
            })
            ->leftJoin('countries', 'countries.id', '=', 'dealerships.country_id')
            ->where('dealerships.id', $id)
            ->first();

        $regions = [];
        if ($dealership->country_id) {
            $regions = Region::where('country_id', $dealership->country_id)
                ->get();
        }

        if($isEvent){
            return [
                'dealership' => $dealership,
                'regions' => $regions
            ];
        }

        return response()->json([
            'dealership' => $dealership,
            'regions' => $regions
        ]);

    }
}