<?php

namespace App\Http\Controllers\Dealership;

use App\BrandDealership;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandDealershipRequest;
use Illuminate\Http\Request;

class BrandDealershipController extends Controller
{
    public function index($dealershipId){

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
