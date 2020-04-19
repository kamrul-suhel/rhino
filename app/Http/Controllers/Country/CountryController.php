<?php

namespace App\Http\Controllers\Country;

use App\Brand;
use App\CountyTranslation;
use App\Region;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::select(
            'countries.*',
            'countries_translation.name'
        )->leftJoin('countries_translation', function($countryT){
            $countryT->on('countries_translation.country_id', '=', 'countries.id')
                ->where('countries_translation.language_id', $this->languageId);
        });
        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search by name
            if ($request->has('search') && !empty($request->search)) {
                $countries = $countries->where('name', 'LIKE', '%' . $request->search . '%');
            }

            // Get Only active country
            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case 'active':
                        $countries = $countries->where('status', 1);
                        break;

                    case 'inactive':
                        $countries = $countries->where('status', 0);
                        break;
                }
            }

            $countries = $countries->orderBy('name');

            $countries = $countries->paginate($this->perPage);
            $data = $countries->items();
            $total = $countries->total();


            return response()->json([
                'data' => $data,
                'total' => $total
            ]);
        }
        $countries = $countries->orderBy('name');
        $countries = $countries->get();

        return response()->json($countries);
    }

    /**
     * Get the countries dropdown list
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountriesDropDown()
    {
        $countries = Country::select(
            'countries.*',
            'countries_translation.name'
        )->leftJoin('countries_translation', function($countryT){
            $countryT->on('countries_translation.country_id','=', 'countries.id')
                ->where('countries_translation.language_id', $this->languageId);
        })
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return response()->json($countries);
    }


    /**
     * get regions base on country id
     * @param $countryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountryRegions($countryId)
    {
        $regions = Region::select('name', 'id')
            ->where([
                'country_id' => $countryId,
                'status' => 1
            ])
            ->orderBy('name')
            ->get();

        return response()->json($regions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $country = new Country;

        $request->has('code') ? $country->country_code = $request->code : null;
        $request->has('seating_position') ? $country->driver_seating_position = $request->seating_position : null;
        $request->has('status') ? $country->status = $request->status  : $country->status = 0;
        $country->save();

        // Add record to country translation table
        $countyTranslation = new CountyTranslation();
        $countyTranslation->name = $request->name;
        $countyTranslation->country_id = $country->id;
        $countyTranslation->language_id = $this->languageId;
        $countyTranslation->save();

        // Create "no region" for each brand for this country
        $brands = Brand::all();
        foreach ($brands as $brand){
            $region = new Region;
            $region->brand_id = $brand->id;
            $region->country_id = $country->id;
            $region->name = 'No Region';
            $region->save();
        }

        return $country;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (
            $request->has('edit') &&
            !empty($request->edit) &&
            $request->edit == true
        ) {
            CountyTranslation::firstOrCreate([
                'language_id' => (int)$this->languageId,
                'country_id' => (int)$id
            ],
                [
                    'language_id' => $this->languageId,
                    'country_id' => $id,
                    'name' => ''
                ]
            );
        }
        $country = Country::select(
            'countries.*',
            'countries_translation.name',
            'countries_translation.language_id'
        )->leftJoin('countries_translation', function($countryT){
            $countryT->on('countries.id', '=', 'countries_translation.country_id')
                ->where('countries_translation.language_id', $this->languageId);
        })->first();

        return response()->json($country);
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
        $country = Country::findOrFail($id);
        $request->has('country_code') ? $country->country_code = $request->country_code : null;
        $request->has('driver_seating_position') ? $country->driver_seating_position = $request->driver_seating_position : null;
        $request->has('status') ? $country->status = 1 : 0;

        // Save country
        $country->save();

        // Update country translation record
        $countryTranslation = CountyTranslation::where([
            'language_id' => $this->languageId,
            'country_id' => $id
        ])->first();

        $request->has('name') ? $countryTranslation->name = $request->name : null;
        $countryTranslation->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return response()->json(['success' => true]);
    }
}
