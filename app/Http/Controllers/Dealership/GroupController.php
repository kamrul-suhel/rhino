<?php

namespace App\Http\Controllers\Dealership;

use App\Group;
use App\GroupTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $total = 0;

        $groups = Group::select(
            'groups.*',
            'groups_translation.name',
            'groups_translation.language_id'
        )
            ->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id')
            ->where('groups_translation.language_id', $this->languageId);

        // Check filter by status
        if (
            $request->has('status') &&
            !empty($request->status)
        ) {
            $groups = $groups->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $groups = $groups->where('groups_translation.name', 'LIKE', '%' . $request->search . '%');
        }

        $groups = $groups->orderBy('id', 'DESC');

        if ($request->has('paginate') && !empty($request->paginate)) {
            $groups = $groups->paginate($this->perPage);
            $total = $groups->total();
            $groups = $groups->items();
        } else {
            $groups = $groups->get();
        }

        return response()->json([
            'groups' => $groups,
            'total' => $total
        ]);
    }


    /**
     * Store group
     * @param GroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GroupRequest $request)
    {
        $group = new Group();
        $request->has('logo') ? $group->logo = $request->logo : null;
        $request->has('status') ? $group->status = $request->status : null;
        $group->save();

        // Make translation
        $groupTranslation = new GroupTranslation();
        $request->has('name') ? $groupTranslation->name = $request->name : null;
        $groupTranslation->language_id = $this->languageId;
        $groupTranslation->group_id = $group->id;

        $groupTranslation->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $request->has('logo') ? $group->logo = $request->logo : null;
        $request->has('status') ? $group->status = $request->status : null;
        $group->save();

        // Update group translation
        $groupTranslation = GroupTranslation::where([
            'group_id' => $id,
            'language_id' => $this->languageId
        ])->first();

        $request->has('name') ? $groupTranslation->name = $request->name : null;
        $groupTranslation->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        // Check specified language is exists or not, if not then create one and send back
        if (
            $request->has('edit') &&
            !empty($request->edit) &&
            $request->edit == true
        ) {
            GroupTranslation::firstOrCreate([
                'language_id' => $this->languageId,
                'group_id' => $id
            ],
                [
                    'name' => ''
                ]
            );
        }

        $group = Group::select(
            'groups.*',
            'groups_translation.name',
            'groups_translation.language_id'
        )
            ->leftJoin('groups_translation', 'groups_translation.group_id', '=', 'groups.id')
            ->where('groups_translation.language_id', $this->languageId)
            ->where('groups.id', $id)
            ->first();

        return response()->json([
            'group' => $group
        ]);
    }

    public function destroy($id){
        $group = Group::findOrFail($id);

        $group->delete();

        return response()->json(['success' => true]);
    }
}
