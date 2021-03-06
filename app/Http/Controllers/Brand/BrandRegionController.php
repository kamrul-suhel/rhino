<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Http\Request;

class BrandRegionController extends Controller
{
    /**
     * Get the regions based on brand id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegions(Request $request, $brandId)
    {
        $total = 0;
        $data = [];

        $regions = Region::select(
            'regions.country_id',
            'regions.id',
            'regions.name',
            'countries_translation.name as country'
        )
            ->leftJoin('countries', function($country){
                $country->on('countries.id', '=', 'regions.country_id')
                    ->leftJoin('countries_translation', 'countries_translation.country_id', '=', 'countries.id')
                    ->where('countries_translation.language_id', $this->languageId);
            });

        if ($request->has('model') && !empty($request->model)) {
            $modelId = $request->model . '_id';
            $regions = $regions->where($modelId, $brandId);
        } else {
            $regions = $regions->where('regions.brand_id', $brandId);
        }

        if($request->has('countryId')){
            $regions = $regions->where('regions.country_id', $request->countryId);
        }

        if ($request->has('paginate') && !empty($request->paginate)) {
            $regions = $regions->paginate($this->perPage);
            $data = $regions->items();
            $total = $regions->total();
        } else {
            $data = $regions->get();
            $total = $regions->count();
        }

        return response()->json(
            [
                'regions' => $data,
                'total' => $total
            ]
        );
    }
}
