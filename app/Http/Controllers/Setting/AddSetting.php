<?php


namespace App\Http\Controllers\Setting;


use App\Setting;
use App\SettingTranslation;
use Illuminate\Support\Facades\DB;
use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class AddSetting
{
    public static function getSettingArray()
    {
        $dir = __DIR__.DIRECTORY_SEPARATOR.'trans';
        $files = scandir($dir);
        $filePath = [];

        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $filePath[] = $path;
            }
        }

        return $filePath;
    }

    public static function addToDatabase()
    {
        $filesPath = self::getSettingArray();

        // Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        SettingTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $languageId = 1; // By default english is language table
        foreach($filesPath as $path){
            $settingArray = include $path;

            foreach ($settingArray as $item) {
                /*
                 * Check exist identifier, to prevent duplication
                 */
                $existsSetting = Setting::where('identifier', $item['identifier'])->first();
                if($existsSetting){
                    continue;
                }

                $setting = new Setting();
                $setting->identifier = $item['identifier'];
                $setting->label = $item['label'];
                $setting->save();

                $settingTranslation = new SettingTranslation();
                $settingTranslation->setting_id = $setting->id;
                $settingTranslation->language_id = $languageId;
                $settingTranslation->translation = $item['label'];

                $settingTranslation->save();
            }
        }

        return ['success' => true];
    }
}
