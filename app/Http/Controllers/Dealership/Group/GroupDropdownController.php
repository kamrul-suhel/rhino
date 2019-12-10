<?php

namespace App\Http\Controllers\Dealership\Group;

use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupDropdownController extends Controller
{
    public function index(Request $request){
        $groups = Group::select(
            'groups.*',
            'groups_translation.name',
            'groups_tr.nslation.language_id'
        )
            ->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id')
            ->where('groups_translation.language_id', $this->languageId);

        $groups = $groups->orderBy('id', 'DESC');

        $groups = $groups->get();

        return response()->json([
            'groups' => $groups,
            'total' => $groups->count()
        ]);
    }
}
