<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $translations = Setting::select(
            'settings.*',
            'settings_translation.id as setting_translation_id',
            'settings.label',
            'settings_translation.translation'
        )->leftJoin('settings_translation', function ($settingTranslation) {
            $settingTranslation->on('settings_translation.setting_id', '=', 'settings.id')
                ->where('settings_translation.language_id', $this->languageId);
        });

        if($request->has('paginate') && !empty($request->paginate)){
            // Search by name
            if($request->has('search') && !empty($request->search)){
                $translations = $translations->where('settings.label', 'LIKE','%'.$request->search.'%');
            }
        }

        $translations = $translations->orderBy('settings.identifier')
            ->paginate($this->perPage);

        return response()->json([
            'translations' => $translations->items(),
            'total' => $translations->total()
        ]);
    }
}
