<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Language;
use App\SettingTranslation;
use Illuminate\Http\Request;

class LanguageDeleteController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Language::findOrFail($id);

        // Delete setting field, which associate with this language id
        SettingTranslation::where('language_id', $language->id)
            ->delete();

        $language->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
