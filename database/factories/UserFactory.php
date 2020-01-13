<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $accessLevels = [
        'admin',
        'dealership',
        'group',
        'region',
        'country',
        'brand',
        'company',
        'sale_executive'
    ];

    $accessLevel = $faker->randomElement($accessLevels);

    return [
        'firstname' => $faker->name,
        'surname' => $faker->lastName,
        'email' => 'admin@rhino.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'level'=>'admin',
        'dealership_id' => null,
        'group_id' => null,
        'region_id' => null,
        'country_id' => null,
        'manufacturer_id' => null,
        'company_id' => null,
        'notes' => $faker->paragraph,
        'profile_image' => $faker->imageUrl(40,40, 'people'),
        'send_mail' => $faker->randomElement([0,1]),
        'status' => $faker->randomElement([0,1])
    ];
});
