<?php

namespace App\Http\Controllers\Vehicle;

use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $totalVehicle = 0;
        $vehicle = Brand::select(
            'vehicles.id',
            'vehicles.driver_seating_position_left_image',
            'vehicles.driver_seating_position_right_image',
            'vehicles_translation.model as model',
        )
            ->leftJoin('vehicles_translation', 'vehicle_translation.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('brands', 'brands.id', '=', 'vehicle.brand_id')
            ->leftJoin('brands_translation', 'brands.id', '=', 'brands_translation.brand_id')
            ->where('vehicles_translation.language_id', $this->languageId)
            ->where('companies_translation.language_id', $this->languageId);

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $brands = $brands->where('brands_translation.name', 'LIKE', '%' . $request->search . '%');
            }

            // Get Only active country
            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case 'active':
                        $brands = $brands->where('status', 1);
                        break;

                    case 'inactive':
                        $brands = $brands->where('status', 0);
                        break;
                }
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                switch ($sortBy) {
                    case 'name':
                        $brands = $brands->orderBy('brands_translation.name');
                        break;

                    case 'status':
                        $brands = $brands->orderBy('brands.status', 'DESC');
                        break;
                }
            } else {
                $brands = $brands->orderBy('brands.id', 'DESC');
            }

            $data = $brands->paginate($this->perPage);
            $totalBrand = $data->total();
            $data = $data->items();
        } else {
            $data = $brands->get();
            $totalBrand = $brands->count();
        }

        return response()->json([
            'brands' => $data,
            'total' => $totalBrand
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBrands()
    {
        
    }
}
