<?php

use App\Company;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Company::class, 30)->create();

        $companies = Company::all();

        $companies->each(function($company){
            $languages = \App\Language::all();

            $languages->each(function($language) use ($company){
                $faker = Faker::create();

                \App\CompanyTranslation::create([
                    'company_id' => $company->id,
                    'language_id' => $language->id,
                    'name' => $faker->company. ' - '.$language->name
                ]);
            });
        });
    }
}
