<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Dealership;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandDropDownController extends Controller
{
    /**
     * Get Brands for dropdown list
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBrandsForDropDown(Request $request)
    {
        $brands = Brand::select(
            'brands.id',
            'brands_translation.name'
        )
            ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id');

        if ($request->has('filterBy') && $request->has('dealershipId')) {

            // Get country ID from current dealership
            $dealershipCountry = Dealership::select('dealerships.id', 'countries.id as country_id')
                ->leftJoin('countries', 'countries.id', '=', 'dealerships.country_id')
                ->where('dealerships.id', $request->dealershipId)
                ->first();

            $brands = $brands->leftJoin('regions', 'regions.brand_id', '=', 'brands.id')
                ->leftJoin('countries', 'regions.country_id', '=', 'countries.id')
                ->where('countries.id', $dealershipCountry->country_id)
                ->groupBy('brands.id')
                ->orderBy('brands_translation.name');
        }

        $brands = $brands->where('brands_translation.language_id', $this->languageId)
            ->get();

        return response()->json($brands);
    }

    /**
     * Generate brand for events
     * based on dealership and brand relation
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBrandForEvent($eventId)
    {
        $dealershipId = Event::findOrFail($eventId)->dealership_id;
        $brands = Brand::select(
            'brands.id',
            'brands.logo',
            'brands_translation.name'
        )
            ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id')
            ->leftJoin('brand_dealership','brands.id', '=', 'brand_dealership.brand_id')
            ->where('brands_translation.language_id', $this->languageId)
            ->where('brand_dealership.dealership_id', $dealershipId)
            ->get();

        return response()->json($brands);
    }
}
