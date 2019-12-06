<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
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
        \App\Region::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\App\Region::class, 300)->create();
    }
}
