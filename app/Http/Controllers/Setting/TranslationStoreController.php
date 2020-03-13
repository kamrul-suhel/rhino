<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\SettingTranslation;
use Illuminate\Http\Request;

class TranslationStoreController extends Controller
{


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $settingTranslation = $request->setting_translation_id === 'null' ? new SettingTranslation() : SettingTranslation::find($id);
        $request->has('translation') ? $settingTranslation->translation = $request->translation : null;
        $request->has('setting_id') ? $settingTranslation->setting_id = $request->setting_id : null;
        $request->has('language_id') ? $settingTranslation->language_id = $request->language_id : null;

        $settingTranslation->save();

        return response()->json([
           'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
