<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class BrandSaleExecutive extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSaleExecutives(Request $request, $eventId, $dealershipId)
    {
        $brandIds = explode(',',$request->brands);
        $saleExecutives = User::select(
            'users.*',
            'event_user.user_id',
            'event_user.event_id',
            'brand_user.brand_id',
            'brand_user.user_id'
        )
            ->leftJoin('event_user', 'event_user.user_id', '=', 'users.id')
            ->leftJoin('brand_user', 'users.id', '=', 'brand_user.user_id')
            ->whereIn('brand_user.brand_id', $brandIds)
            ->where('event_user.event_id', $eventId)
            ->with('specializeBrands')
            ->where('users.dealership_id', $dealershipId)
            ->groupBy('users.id')
            ->get();

        return response()->json([
            'success' => true,
            'users' => $saleExecutives
        ]);
    }
}
