<?php

namespace App\Http\Controllers\Auth;

use App\BrandUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserBrandListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $brandUsers = BrandUser::select(
            'brand_user.*',
            DB::raw("CONCAT(users.firstname ,' ', users.surname) as user_name"),
            'brands_translation.name as brand_name'
        )->leftJoin('users', 'users.id', '=', 'brand_user.user_id')
        ->leftJoin('brands', function($brand){
            $brand->on('brands.id', '=', 'brand_user.brand_id')
                ->leftJoin('brands_translation', 'brands_translation.brand_id', '=', 'brands.id')
                ->where('brands_translation.language_id', $this->languageId);
        });

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $brandUsers = $brandUsers->where('brands_translation.name', 'LIKE', '%' . $request->search . '%');
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                switch ($sortBy) {
                    case 'brand':
                        $brandUsers = $brandUsers->orderBy('brands_translation.name');
                        break;

                    case 'user':
                        $brandUsers = $brandUsers->orderBy('brands.status', 'DESC');
                        break;
                }
            } else {
                $brandUsers = $brandUsers->orderBy('brand_user.id', 'DESC');
            }

            $brandUsers = $brandUsers->where('brand_user.user_id', $request->id);

            $data = $brandUsers->paginate($this->perPage);
            $totalBrand = $data->total();
            $data = $data->items();
        } else {
            $brandUsers = $brandUsers->get();
            $totalBrand = $brandUsers->count();
        }

        return response()->json([
            'brands' => $data,
            'total' => $totalBrand
        ]);
    }
}
