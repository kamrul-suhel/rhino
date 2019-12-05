<?php

namespace App\Http\Controllers\Event\Type;

use App\EventType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeDropdownController extends Controller
{
    /**
     * Get event type for dropdown
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $types = EventType::select(
            'types.id',
            'types_translation.name',
            'types_translation.language_id'
        )->leftJoin('types_translation', function ($typeT) {
            $typeT->on('types.id', '=', 'types_translation.type_id');
            $typeT->where('types_translation.language_id', $this->languageId);
        })->where('types.status', 1) // Only active types
        ->get();

        return response()->json([
            'types' => $types,
            'total' => $types->count()
        ]);
    }
}
