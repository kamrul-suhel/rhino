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
            'brands_translation.description',
            'brands.status'
        )
            ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id')
            ->leftJoin('companies', function($company){
                $company->on('companies.id', '=', 'brands.company_id');
                $company->leftJoin('companies_translation', 'companies.id', '=', 'companies_translation.company_id');
                $company->where('companies_translation.language_id', $this->languageId);
            })
            ->where('brands_translation.language_id', $this->languageId);

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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response()->json(['success' => true]);
    }
}
