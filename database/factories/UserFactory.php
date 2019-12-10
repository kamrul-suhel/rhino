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
        'company'
    ];

    $accessLevel = $faker->randomElement($accessLevels);

    return [
        'firstname' => $faker->name,
        'surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'level'=>$accessLevel,
        'dealership_id' => $accessLevel == 'dealership' ? \App\Dealership::all()->random()->id : null,
        'group_id' => $accessLevel == 'group' ? \App\Group::all()->random()->id : null,
        'region_id' => $accessLevel == 'region' ? \App\Region::all()->random()->id : null,
        'country_id' => $accessLevel == 'country' ? \App\Country::all()->random()->id : null,
        'manufacturer_id' => $accessLevel == 'brand' ? \App\Brand::all()->random()->id : null,
        'company_id' => $accessLevel == 'company' ? \App\Company::all()->random()->id : null,
        'notes' => $faker->paragraph,
        'profile_image' => $faker->imageUrl(40,40, 'people'),
        'send_mail' => $faker->randomElement([0,1]),
        'status' => $faker->randomElement([0,1])
    ];
});
