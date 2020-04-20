<?php

namespace App\Http\Controllers\Dealership;

use App\Dealership;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealershipListController extends Controller
{

    /**
     * Show all dealerships
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
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
            'groups_translation.language_id',
            'groups.logo as group_logo',
            'groups.id as group_id',
            'countries_translation.name as country'
        )
            ->leftJoin('dealerships_translation', function($dealershipT){
                $dealershipT->on('dealerships_translation.dealership_id', '=', 'dealerships.id')
                    ->where('dealerships_translation.language_id', $this->languageId);
            })
            ->leftJoin('groups', function ($group) {
                $group->on('groups.id', '=', 'dealerships.group_id');
                $group->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id');
                $group->where('groups_translation.language_id', '=', $this->languageId);
            })
            ->leftJoin('countries', function($country){
                $country->on('countries.id', '=', 'dealerships.country_id')
                    ->leftJoin('countries_translation', function($countryT){
                       $countryT->on('countries_translation.country_id', '=', 'countries.id')
                       ->where('countries_translation.language_id', $this->languageId);
                    });
            });

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $dealerships = $dealerships->where('dealerships_translation.name', 'LIKE', '%' . $request->search . '%');
            }

            //Filter by status
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
                    case 'group':
                        $dealerships = $dealerships->orderBy('groups_translation.name');
                        break;

                    case 'country':
                        $dealerships = $dealerships->orderBy('countries_translation.name');
                        break;
                }
            } else {
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
}
