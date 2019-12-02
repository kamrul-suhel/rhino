<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\BrandTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Region;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $totalBrand = 0;
        $brands = Brand::select(
            'brands.id',
            'brands.logo',
            'brands.colour',
            'brands.company_id',
            'brands_translation.name',
            'companies_translation.name as company',
            'brands_translation.description'
        )
            ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id')
            ->leftJoin('companies', 'companies.id', '=', 'brands.company_id')
            ->leftJoin('companies_translation', 'companies.id', '=', 'companies_translation.company_id')
            ->where('brands_translation.language_id', $this->languageId)
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
        $brand->status = $request->status;
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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Check request is edit or only show
        if ($request->has('edit') &&
            !empty($request->edit) &&
            $request->edit == 'true'
        ) {
            BrandTranslation::firstOrCreate(
                [
                    'language_id' => $this->languageId,
                    'brand_id' => $id
                ],
                [
                    'name' => '',
                    'description' => ''
                ]);
        }


        $brand = Brand::select(
            'brands.id',
            'brands.logo',
            'brands.status',
            'brands.colour',
            'brands.company_id',
            'brands_translation.name',
            'brands_translation.language_id',
            'brands_translation.description'
        )
            ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id')
            ->where('brands.id', $id)
            ->where('brands_translation.language_id', $this->languageId)
            ->first();

        return response([
            'brand' => $brand
        ]);
    }


    /**
     * Get the regions based on brand id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegions(Request $request, $brandId)
    {
        $total = 0;
        $data = [];

        $regions = Region::select(
            'regions.country_id',
            'regions.id',
            'regions.name',
            'countries.name as country'
        )
            ->leftJoin('countries', 'countries.id', '=', 'regions.country_id');

        if ($request->has('model') && !empty($request->model)) {
            $modelId = $request->model . '_id';
            $regions = $regions->where($modelId, $brandId);
        } else {
            $regions = $regions->where('brand_id', $brandId);
        }

        if ($request->has('paginate') && !empty($request->paginate)) {
            $regions = $regions->paginate($this->perPage);
            $data = $regions->items();
            $total = $regions->total();
        } else {
            $data = $regions->get();
            $total = $regions->count();
        }

        return response()->json(
            [
                'regions' => $data,
                'total' => $total
            ]
        );
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
        $request->has('company_id') ? $brand->company_id = $request->company_id : null;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
