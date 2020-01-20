<?php

namespace App\Http\Controllers\Auth;

use App\BrandUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserBrandRequest;
use Illuminate\Http\Request;

class UserBrandStoreController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     * @param UserBrandRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserBrandRequest $request)
    {
        $userBrand = $this->save($request);

        if(!$userBrand){
            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'brand' => $userBrand
        ]);
    }


    public function update(UserBrandRequest $request){
        $userBrand = $this->save($request, $request->id);

        if(!$userBrand){
            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'brand' => $userBrand
        ]);
    }

    /**
     * Protected function for create or update
     * @param UserBrandRequest $request
     * @param null $id
     * @return BrandUser
     */
    protected function save(UserBrandRequest $request, $id = null){
        $userBrand = empty($id) ? new BrandUser() : BrandUser::findOrFail($id);

        $request->has('brand_id') ? $userBrand->brand_id = $request->brand_id : null;
        $request->has('user_id') ? $userBrand->user_id = $request->user_id : null;
        $request->has('new') ? $userBrand->new = $request->new : null;
        $request->has('used') ? $userBrand->used = $request->used : null;
        $userBrand->save();

        return $userBrand;
    }
}
