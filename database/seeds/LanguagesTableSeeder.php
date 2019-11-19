<?php

use Illuminate\Database\Seeder;
use ErnySans\Laraworld\Models\Languages;

class LanguagesTableSeeder extends Seeder
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
        Languages::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get all from the JSON file
        $JSON_languages = Languages::allJSON();

        foreach ($JSON_languages as $language) {
            Languages::create([
                'code2'    => ((isset($language['alpha2'])) ? $language['alpha2'] : null),
                'code3'    => ((isset($language['alpha3'])) ? $language['alpha3'] : null),
                'status'    => 1,
                'name'   => ((isset($language['english'])) ? $language['english'] : null),
            ]);
        }
    }
}
