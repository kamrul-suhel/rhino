<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\BrandTranslation;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;

class BrandStoreController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $brand = New Brand();
        $brand->logo = $request->logo;
        $brand->colour = $request->colour;
        $brand->company_id = $request->company_id;
        $brand->status = 1;
        $brand->save();

        // Create brand Translation
        $brandTranslation = New BrandTranslation();
        $brandTranslation->name = $request->name;
        $brandTranslation->brand_id = $brand->id;
        $brandTranslation->language_id = $this->languageId;
        $brandTranslation->save();

        return response()->json(['success' => true]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update brand
        $brand = Brand::findOrFail($id);
        $request->has('logo') ? $brand->logo = $request->logo : null;
        $request->has('company_id') && !empty($request->company_id) ? $brand->company_id = $request->company_id : null;
        $request->has('status') ? $brand->status = $request->status : null;
        $request->has('colour') ? $brand->colour = $request->colour : null;
        $brand->save();

        // Update brand translation
        $brandTranslation = BrandTranslation::where([
            'brand_id' => $brand->id,
            'language_id' => $this->languageId
        ])->first();

        $request->has('name') ? $brandTranslation->name = $request->name : null;
        $request->has('description') ? $brandTranslation->description = $request->description : null;

        $brandTranslation->save();

        return response()->json(['success' => true]);
    }
}
