<?php

namespace App\Http\Controllers\Event\Type;

use App\EventType;
use App\EventTypeTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventTypeRequest;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Show all Event types
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $total = 0;

        $types = EventType::select(
            'types.*',
            'types_translation.name',
            'types_translation.display_name',
            'types_translation.description',
            'types_translation.language_id'
        )
            ->leftJoin('types_translation', 'types_translation.type_id', '=', 'types.id')
            ->where('types_translation.language_id', $this->languageId);

        // Check filter by status
        if (
            $request->has('status') &&
            !empty($request->status)
        ) {
            $types = $types->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $types = $types->where('types_translation.name', 'LIKE', '%' . $request->search . '%');
        }

        $types = $types->orderBy('id', 'DESC');

        if ($request->has('paginate') && !empty($request->paginate)) {
            $types = $types->paginate($this->perPage);
            $total = $types->total();
            $types = $types->items();
        } else {
            $types = $types->get();
        }

        return response()->json([
            'types' => $types,
            'total' => $total
        ]);
    }


    /**
     * Store newly create type
     * @param EventTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventTypeRequest $request)
    {
        $type = new EventType();
        $request->has('logo') ? $type->image = $request->logo : null;
        $request->has('status') ? $type->status = $request->status : null;
        $type->save();

        // Make translation
        $typeTranslation = new EventTypeTranslation();
        $request->has('name') ? $typeTranslation->name = $request->name : null;
        $request->has('display_name') ? $typeTranslation->display_name = $request->display_name : null;
        $request->has('description') ? $typeTranslation->description = $request->description : null;
        $typeTranslation->language_id = $this->languageId;
        $typeTranslation->type_id = $type->id;

        $typeTranslation->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $type = EventType::findOrFail($id);
        $request->has('logo') ? $type->image = $request->logo : null;
        $request->has('status') ? $type->status = $request->status : null;
        $type->save();

        // Update type translation
        $typeTranslation = EventTypeTranslation::where([
            'type_id' => $id,
            'language_id' => $this->languageId
        ])->first();

        $request->has('name') ? $typeTranslation->name = $request->name : null;
        $request->has('display_name') ? $typeTranslation->display_name = $request->display_name : null;
        $request->has('description') ? $typeTranslation->description = $request->description : null;
        $typeTranslation->save();

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
            EventTypeTranslation::firstOrCreate([
                'language_id' => $this->languageId,
                'type_id' => $id
            ],
                [
                    'name' => ''
                ]
            );
        }

        $type = EventType::select(
            'types.*',
            'types_translation.name',
            'types_translation.display_name',
            'types_translation.description',
            'types_translation.language_id'
        )
            ->leftJoin('types_translation', 'types_translation.type_id', '=', 'types.id')
            ->where('types_translation.language_id', $this->languageId)
            ->where('types.id', $id)
            ->first();

        return response()->json([
            'type' => $type
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $type = EventType::findOrFail($id);

        $type->delete();

        return response()->json(['success' => true]);
    }
}
