<?php

namespace App\Http\Controllers\Dealership;

use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request){
        $groups = Group::select(
            'groups.*',
            'groups_translation.name'
        )
            ->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id')
            ->where('groups_translation.language_id', $this->languageId)
            ->where('status', 1)
            ->get();

        return response()->json([
            'groups' => $groups
        ]);

    }
}
