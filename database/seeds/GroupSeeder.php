<?php

use App\Group;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GroupSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Group::class, 20)->create();

        $groups = Group::all();

        $groups->each(function($group){
            $languages = \App\Language::all();
            $languages->each(function($language) use ($group){
                $faker = Faker::create();

                \App\GroupTranslation::create([
                    'group_id' => $group->id,
                    'language_id' => $language->id,
                    'name' => $faker->text(30).' - '. $language->name
                ]);
            });
        });
    }
}
