<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Language;
use App\SettingTranslation;
use Illuminate\Http\Request;

class LanguageStoreController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $language = $this->save($request);

        if($language){
            return response()->json([
                'success' => true,
                'language' => $language
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, $id)
    {
        $language = $this->save($request, $id);

        if($language){
            return response()->json([
                'success' => true,
                'language' => $language
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    private function save(LanguageRequest $request, $id = null){

        $language = empty($id) ? new Language() : Language::findOrFail($id);

        $request->has('name') ? $language->name = $request->name : null;
        $request->has('language_code') ? $language->language_code = $request->language_code : null;
        $request->has('country_code') ? $language->country_code = $request->country_code : null;
        $request->has('status') && $request->undefined !== 'undefined' ? $language->status = $request->status : 1; // default state

        $language->save();


        // If create new record then replicate setting translation field
        if(empty($id)){
            $settings = SettingTranslation::where('language_id', 1)
                ->get(); // default language

            $settings->map(function($setting) use ($language) {
                $newField = $setting->replicate();
                $newField->language_id = $language->id;
                $newField->translation = '';
                $newField->save();
            });
        }

        return $language;
    }
}
