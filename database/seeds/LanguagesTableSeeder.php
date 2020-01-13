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
            'code2'    => 'GB',
            'code3'    => 'GBR',
            'status'    => 1,
            'name'   => 'English (UK)'
        ]);
        

        Languages::create([
            'code2'    => 'US',
            'code3'    => 'USA',
            'status'    => 1,
            'name'   => 'English (US)'
        ]);

        
        Languages::create([
            'code2'    => 'FR',
            'code3'    => 'FRA',
            'status'    => 1,
            'name'   => 'French'
        ]);
    }
}
