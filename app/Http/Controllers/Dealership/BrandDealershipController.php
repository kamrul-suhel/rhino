<?php

namespace App\Http\Controllers\Dealership;

use App\BrandDealership;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandDealershipRequest;
use Illuminate\Http\Request;

class BrandDealershipController extends Controller
{
    public function index(Request $request, $dealershipId)
    {
        $data = [];
        $total = 0;

        $brands = BrandDealership::select(
            'brand_dealership.*',
            'brands_translation.name as brand',
            'regions.name as region',
            'countries_translation.name as country'
        )->leftJoin('brands', function ($brand) {
            $brand->on('brands.id', '=', 'brand_dealership.brand_id');
            $brand->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id');
            $brand->where('brands_translation.language_id', $this->languageId);
        })->leftJoin('regions', function($region){
            $region->on('regions.id', '=', 'brand_dealership.region_id')
                ->leftJoin('countries_translation', function($countryT){
                      $countryT->on('countries_translation.country_id', '=', 'regions.country_id')
                      ->where('countries_translation.language_id', $this->languageId);
                });
        })
            ->where('brand_dealership.dealership_id', $dealershipId);

        if ($request->has('paginate')) {
            $brands = $brands->paginate($this->perPage);
            $total = $brands->total();
            $data = $brands->items();

        } else {
            $brands = $brands->get();
            $data = $brands;
            $total = $brands->count();
        }

        return response()->json([
            'brands' => $data,
            'total' => $total
        ]);
    }

    /**
     * Store Brand & Dealership relation
     * @param BrandDealershipRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BrandDealershipRequest $request)
    {
        $brandDealership = new BrandDealership();
        $brandDealership->brand_id = $request->brand_id;
        $brandDealership->region_id = $request->region_id;
        $brandDealership->dealership_id = $request->dealership_id;

        $brandDealership->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Update relation between brand dealership
     * @param BrandDealershipRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BrandDealershipRequest $request, $id){
        $brandDealership = BrandDealership::findOrFail($id);
        $request->has('brand_id') ? $brandDealership->brand_id = $request->brand_id : null;
        $request->has('region_id') ? $brandDealership->region_id = $request->region_id : null;

        $brandDealership->save();

        return response()->json([
            'success' => true
        ]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $brandDealership = BrandDealership::findOrFail($id);
        $brandDealership->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
