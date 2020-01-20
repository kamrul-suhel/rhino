<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserShowController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::select(
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
            ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
            ->where('users.id', $id)
            ->first();

        return response()->json([
            'user' => $user
        ]);
    }
}
