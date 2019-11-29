<?php

namespace App\Http\Controllers\Region;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegionRequest;
use App\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionRequest $request)
    {
        $region = New Region();
        $region->name = $request->name;
        $region->country_id = $request->country_id;
        $region->brand_id = $request->brand_id;
        $region->save();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegionRequest $request, $id)
    {
        $region = Region::findOrFail($id);
        $request->has('name') ? $region->name = $request->name : null;
        $request->has('country_id') ? $region->country_id = $request->country_id: null;
        $region->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return response()->json(['success' => true]);
    }
}
