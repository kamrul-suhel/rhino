<?php

namespace App\Http\Controllers\Dealership;

use App\BrandDealership;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandDealershipRequest;
use Illuminate\Http\Request;

class BrandDealershipController extends Controller
{
    public function index($dealershipId){
        $brands = BrandDealership::select(
            'brand_dealership.*',
            'brands_translation.name as brand',
            'regions.name as region',
            'countries.name as country'
        )->leftJoin('brands', function($brand){
            $brand->on('brands.id', '=', 'brand_dealership.brand_id');
            $brand->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id');
            $brand->where('brands_translation.language_id', $this->languageId);
        })->leftJoin('regions', 'regions.id', '=', 'brand_translation.region_id')
        ->leftJoin('countries', 'regions.country_id', '=', 'countries.id')
        ->get();

        return response()->json([
            'regions' => $brands,
            'total' => $brands->count()
        ]);
    }

    /**
     * Store Brand & Dealership relation
     * @param BrandDealershipRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BrandDealershipRequest $request){
        $brandDealership = new BrandDealership();
        $brandDealership->brand_id = $request->brand_id;
        $brandDealership->region_id = $request->region_id;
        $brandDealership->dealership_id = $request->dealership_id;

        $brandDealership->save();

        return response()->json([
            'success' => true
        ]);
    }
}
