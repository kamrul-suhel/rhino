<?php

namespace App\Http\Controllers\Vehicle;

use App\Brand;
use App\Vehicle;
use App\VehicleTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;


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
            'vehicles.brand_id',
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
                $vehicles = $vehicles->where('vehicles_translation.model', 'LIKE', '%' . $request->search . '%');
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                $vehicles = $vehicles->orderBy('vehicles_translation.model');

            } else {
                $vehicles = $vehicles->orderBy('vehicles.id', 'DESC');
            }

            // If  filterBy Brand is set
            if ( $request->has('filterBy') && !empty($request->filterBy) ) {
                $brandId = $request->brandId;
                $vehicles = $vehicles->where('vehicles.brand_id', $request->brandId);
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
        // Create translation if not exists
        if($request->has('edit') && !empty($request->edit)){
            VehicleTranslation::firstOrCreate([
                'language_id' => $this->languageId,
                'vehicle_id' => $id
            ],[
                'model' => '',
            ]);
        }

        $vehicle = Vehicle::select(
            'vehicles.*',
            'vehicles_translation.language_id',
            'vehicles_translation.model',
            'brands_translation.name as brand',
            'brands.logo as brand_logo'
        )
            ->leftJoin('vehicles_translation', function($vehicleTranslation){
                $vehicleTranslation->on('vehicles_translation.vehicle_id', '=', 'vehicles.id');
                $vehicleTranslation->where('vehicles_translation.language_id', $this->languageId);
            })
            ->leftJoin('brands', function ($brand) {
                $brand->on('brands.id', '=', 'vehicles.brand_id');
                $brand->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id');
                $brand->where('brands_translation.language_id', '=', $this->languageId);
            })
            ->where('vehicles.id', $id)
            ->first();

        $brand = [];
        if ($vehicle->brand_id) {
            $brand = Brand::select(
                'brands.*',
                'brands_translation.name'
            )
                ->leftJoin('brands_translation', function($brandTranslation){
                    $brandTranslation->on('brands_translation.brand_id', '=', 'brands.id');
                    $brandTranslation->where('brands_translation.language_id', $this->languageId);
                })
                ->where('brands.id', $vehicle->brand_id)
                ->first();
        }
        return response()->json([
            'vehicle' => $vehicle,
            'brand' => $brand
        ]);



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleRequest $request, $id)
    {
        $vehicle = $this->saveVehicle($request, $id);
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
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return response()->json(['success' => true]);
    }


    /**
     * Save or update vehicle
     * @param VehicleRequest $request
     * @param null $vehicleId
     * @return bool
     */
    private function saveVehicle(VehicleRequest $request, $vehicleId = null)
    {

        $vehicle = $vehicleId === null ? new Vehicle() : Vehicle::findOrFail($vehicleId);

        $request->has('brand_id') ? $vehicle->brand_id = $request->brand_id : null;
        $request->has('leftImage') ? $vehicle->driver_seating_position_left_image = $request->leftImage : '';
        $request->has('rightImage') ? $vehicle->driver_seating_position_right_image = $request->rightImage : '';

        $vehicle->save();

        // Translation
        $vehicleTranslation = $vehicleId === null ? new VehicleTranslation() :
            VehicleTranslation::where([
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
