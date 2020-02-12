<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Seed the countries
//        $this->call(CountriesTableSeeder::class);

        // Seed the Time Zones
        //$this->call(TimeZonesTableSeeder::class);

        // Seed the Languages
//        $this->call(LanguagesTableSeeder::class);

        // Seed the setting table
        //$this->call(SettingsTableSeeder::class);

        // Seed the company & company translation
        //$this->call(CompanySeeder::class);

        // Seed Brand table
        //$this->call(BrandSeeder::class);

        // Seed Vehicle table
        //$this->call(VehicleSeeder::class);

        // Seed dealership group table
        //$this->call(GroupSeeder::class);

        // Seed Dealership table
        //$this->call(DealershipSeeder::class);

        // Seed Event type table
        //$this->call(EventTypeSeeder::class);

        // Seed Event table
        //$this->call(EventSeeder::class);

        // Seed Region table
        //$this->call(RegionSeeder::class);

        // Seed Brand Dealership  table
        //$this->call(BrandDealershipSeeder::class);


        // Seed User  table
//        $this->call(UserSeeder::class);

        // Seed Guest  table
         $this->call(GuestSeeder::class);
    }
}
