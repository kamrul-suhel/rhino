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
        $this->call(CountriesTableSeeder::class);

        // Seed the Time Zones
        $this->call(TimeZonesTableSeeder::class);

        // Seed the Languages
        $this->call(LanguagesTableSeeder::class);

        // Seed the setting table
        $this->call(SettingsTableSeeder::class);

        // Seed the company & company translation
//        $this->call(CompanySeeder::class);

        // Seed dealership group table
        $this->call(GroupSeeder::class);

        // Seed Dealership table
        $this->call(DealershipSeeder::class);

        // Seed Brand table
//        $this->call(BrandSeeder::class);
    }
}
