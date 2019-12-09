<?php

namespace App\Http\Controllers\Vehicle;

use App\Vehicle;
use App\VehicleTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use Illuminate\Http\Request;


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
        $vehicles = Vehicle::select(
            'vehicles.id',
            'vehicles.driver_seating_position_left_image',
            'vehicles.driver_seating_position_right_image',
            'vehicles_translation.model as model',
            'brands_translation.name as brand'
        )
            ->leftJoin('vehicles_translation', 'vehicles_translation.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('brands', 'brands.id', '=', 'vehicles.brand_id')
            ->leftJoin('brands_translation', 'brands.id', '=', 'brands_translation.brand_id')
            ->where('vehicles_translation.language_id', $this->languageId)
            ->where('brands_translation.language_id', $this->languageId);

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search vehicle name
            if ($request->has('search') && !empty($request->search)) {
                $vehicles = $vehicle->where('vehicles_translation.model', 'LIKE', '%' . $request->search . '%');
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                $vehicles = $vehicles->orderBy('vehicles_translation.model');
                
            } else {
                $vehicles = $vehicles->orderBy('vehicles.id', 'DESC');
            }

            $data = $vehicles->paginate($this->perPage);
            $totalVehicle = $data->total();
            $data = $data->items();
        } else {
            $data = $vehicles->get();
            $totalVehicle = $vehicles->count();
        }

        return response()->json([
            'vehicles' => $data,
            'total' => $totalVehicle
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
    public function store(VehicleRequest $request)
    {
        $vehicle = $this->saveVehicle($request);
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
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
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return response()->json(['success' => true]);
    }

    
    private function saveVehicle(VehicleRequest $request, $vehicleId = null)
    {

        $vehicle = $vehicleId === null ? new Vehicle() : Vehicle::findOrFail($vehicleId);

        $request->has('brand_id') ? $vehicle->brand_id = $request->brand_id : null;
        
        $vehicle->save();
        
        // Translation
        $vehicleTranslation = $vehicleId === null ? new VehicleTranslation() :
            VeicleTranslation::where([
                'vehicle_id' => $vehicle->id,
                'language_id' => $this->languageId
            ])->first();
        
        $vehicleTranslation->vehicle_id = $vehicle->id;
        $vehicleTranslation->language_id = $this->languageId;
        $request->has('model') ? $vehicleTranslation->model = $request->model : null;

        $vehicleTranslation->save();

        return true;

    }

}
