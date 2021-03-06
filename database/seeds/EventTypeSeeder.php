<?php

use App\EventType;
use App\EventTypeTranslation;
use App\Language;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventTypeSeeder extends Seeder
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
        EventType::truncate();
        EventTypeTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        factory(EventType::class, 30)->create();

        $events = EventType::all();

        $events->each(function($event){
            $languages = Language::all();
            $faker = Faker::create();
            $languages->each(function($language) use ($event, $faker){
                EventTypeTranslation::create([
                    'type_id' => $event->id,
                    'language_id' => $language->id,
                    'name' => $faker->text(20) . ' - '.$language->name
                ]);
            });
        });
    }
}
