<?php

use App\Guest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuestSeeder extends Seeder
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
        Guest::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Guest::class, 300)->create();
    }
}
