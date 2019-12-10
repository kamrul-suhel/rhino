<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $data = [];
        $totalUsers = 0;
        $users = User::select(
            'users.*',
            'dealerships.id as dealership_id',
            'dealerships_translation.name as dealership',
            'groups_translation.name as group',
            'groups.id as group_id',
            'regions.name as region'
        )
            ->leftJoin('dealerships', function($dealership){
                $dealership->on('dealerships.id', '=', 'users.dealership_id');
                $dealership->leftJoin('dealerships_translation', 'dealerships_translation.dealership_id', '=', 'dealerships.id');
                $dealership->where('dealerships_translation.language_id', $this->languageId);
            })

            ->leftJoin('groups', function($group){
                $group->on('groups.id', '=', 'users.group_id');
                $group->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id');
                $group->where('groups_translation.language_id','=', $this->languageId);
            })

            ->leftJoin('regions', 'regions.id', '=', 'users.region_id')

            ->leftJoin('countries', 'countries.id', '=', 'users.country_id');

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $users = $users->where('users.email', 'LIKE', '%' . $request->search . '%');
            }

            // Get Only active country
            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case 'active':
                        $users = $users->where('status', 1);
                        break;

                    case 'inactive':
                        $users = $users->where('status', 0);
                        break;
                }
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                switch ($sortBy) {
                    case 'name':
                        $users = $users->orderBy('users.firstname');
                        break;

                    case 'email':
                        $users = $users->orderBy('users.email', 'DESC');
                        break;
                }
            } else {
                $users = $users->orderBy('users.id', 'DESC');
            }

            $data = $users->paginate($this->perPage);
            $totalUsers = $data->total();
            $data = $data->items();
        } else {
            $data = $users->get();
            $totalUsers = $users->count();
        }

        return response()->json([
            'users' => $data,
            'total' => $totalUsers
        ]);
    }
}
