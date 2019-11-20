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
                'label' => 'All Dealerships',
                'identifier' => 'all_dealerships',
                'translation' => 'All Dealerships'
            ],
            [
                'label' => 'Add Dealerships',
                'identifier' => 'add_dealerships',
                'translation' => 'Add Dealerships'
            ],
            [
                'label' => 'Edit Dealerships',
                'identifier' => 'edit_dealerships',
                'translation' => 'Edit Dealerships'
            ],
            [
                'label' => 'Groups',
                'identifier' => 'groups',
                'translation' => 'Groups'
            ],
            [
                'label' => 'Add Groups',
                'identifier' => 'add_groups',
                'translation' => 'Add Groups'
            ],
            [
                'label' => 'Create Groups',
                'identifier' => 'create_groups',
                'translation' => 'Create Groups'
            ],
            [
                'label' => 'Edit Groups',
                'identifier' => 'edit_groups',
                'translation' => 'Edit Groups'
            ],
            [
                'label' => 'Create Dealerships',
                'identifier' => 'create_dealerships',
                'translation' => 'Create Dealerships'
            ],
            [
                'label' => 'Update Dealerships',
                'identifier' => 'update_dealerships',
                'translation' => 'Update Dealerships'
            ],
            [
                'label' => 'Languages',
                'identifier' => 'languages',
                'translation' => 'Languages'
            ],
            [
                'label' => 'Add Language',
                'identifier' => 'add_language',
                'translation' => 'Add Language'
            ],
            [
                'label' => 'Create Language',
                'identifier' => 'create_language',
                'translation' => 'Create Language'
            ],
            [
                'label' => 'Edit Language',
                'identifier' => 'edit_language',
                'translation' => 'Edit Language'
            ],
            [
                'label' => 'Update Language',
                'identifier' => 'update_language',
                'translation' => 'Update Language'
            ],
            [
                'label' => 'Select a language',
                'identifier' => 'select_a_language',
                'translation' => 'Select a language'
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
