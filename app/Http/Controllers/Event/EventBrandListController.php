<?php

namespace App\Http\Controllers\Event;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventBrandListController extends Controller
{
    public function getBrandsByEventId(Request $request, $eventId){
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
            ->leftJoin('brand_event', 'brand_event.brand_id', '=', 'brands.id')
            ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id')
            ->leftJoin('companies', 'companies.id', '=', 'brands.company_id')
            ->leftJoin('companies_translation', 'companies.id', '=', 'companies_translation.company_id')
            ->where('brands_translation.language_id', $this->languageId)
            ->where('companies_translation.language_id', $this->languageId)
            ->where('brand_event.event_id', $eventId);

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
}
