<?php

use App\Setting;
use App\SettingTranslation;
use Illuminate\Database\Seeder;
use ErnySans\Laraworld\Models\Languages;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        // Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        SettingTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $settingArray = [
          [
              'label' => 'Home',
              'identifier' => 'home',
              'translation' => 'Home'
          ]
        ];

        $languageId = 1; // By default english is language table

        foreach($settingArray as $item){
            $setting = Setting::create([
                'identifier' => $item['identifier'],
                'label' => $item['label']
            ]);

            $settingTranslation = SettingTranslation::create([
                'setting_id' => $setting->id,
                'language_id' => $languageId,
                'translation' => $item['translation']
            ]);
        }

    }
}
