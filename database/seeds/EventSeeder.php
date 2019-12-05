<?php

use App\Event;
use App\EventTranslation;
use App\EventType;
use App\EventTypeTranslation;
use App\Language;
use App\Setting;
use App\SettingTranslation;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
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
        Event::truncate();
        EventTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Event::class, 30)->create();

        $events = Event::all();

        $events->each(function ($event) {
            $languages = Language::all();
            $faker = Faker::create();
            $languages->each(function ($language) use ($event, $faker) {
                EventTranslation::create([
                    'event_id' => $event->id,
                    'language_id' => $language->id,
                    'name' => $faker->text(20) . ' - ' . $language->name,
                    'notes' => $faker->text(200) . ' - ' . $language->name,
                    'greeting' => $faker->text(200) . ' - ' . $language->name
                ]);
            });
        });
    }
}
