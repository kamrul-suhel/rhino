<?php


namespace App\Http\Controllers\Setting;


use App\Setting;
use App\SettingTranslation;
use Illuminate\Support\Facades\DB;

class AddSetting
{
    public static function getSettingArray(){
        return [
        [
             'label' => 'Home',
             'identifier' => 'home',
             'translation' => 'Home'
         ],
         [
              'label' => 'Dealerships',
              'identifier' => 'dealerships',
              'translation' => 'Dealerships'
          ],
          [
                'label' => 'Add Dealerships',
                'identifier' => 'add_dealerships',
                'translation' => 'Add Dealerships'
            ]
         ];
    }

    public static function addToDatabase(){
        $settingArray = self::getSettingArray();

        $languageId = 40; // By default english is language table

        dd($languageId);
        foreach($settingArray as $item){
            $setting = Setting::create([
                'identifier' => $item['identifier']
            ]);

            $settingTranslation = SettingTranslation::create([
                'setting_id' => $setting->id,
                'language_id' => $languageId,
                'label' => $item['label'],
                'translation' => $item['translation']
            ]);
        }

        return ['success' => true];
    }
}
