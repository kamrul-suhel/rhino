<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandDropDownController extends Controller
{
    /**
     * Get Brands for dropdown list
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBrandsForDropDown(){
        $brands = Brand::select(
            'brands.id',
            'brands_translation.name'
        )
            ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id')
            ->where('brands_translation.language_id', $this->languageId)
            ->get();

        return response()->json($brands);
    }
}
