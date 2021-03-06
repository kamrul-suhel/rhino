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


        Languages::create([
            'language_code'    => 'GB',
            'country_code'    => 'GBR',
            'status'    => 1,
            'name'   => 'English (UK)'
        ]);
    }
}
