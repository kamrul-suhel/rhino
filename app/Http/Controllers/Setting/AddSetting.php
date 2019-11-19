<?php


namespace App\Http\Controllers\Setting;


use App\Setting;
use App\SettingTranslation;
use Illuminate\Support\Facades\DB;

class AddSetting
{
    public static function getSettingArray()
    {
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

    public static function addToDatabase()
    {
        $settingArray = self::getSettingArray();

        // Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        SettingTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $languageId = 40; // By default english is language table
        foreach ($settingArray as $item) {
            $setting = new Setting();
            $setting->identifier = $item['identifier'];
            $setting->save();

            $settingTranslation = new SettingTranslation();
            $settingTranslation->setting_id = $setting->id;
            $settingTranslation->language_id = $languageId;
            $settingTranslation->label = $item['label'];
            $settingTranslation->translation = $item['translation'];

            $settingTranslation->save();
        }

        return ['success' => true];
    }
}
