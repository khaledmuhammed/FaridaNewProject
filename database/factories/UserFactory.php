<?php

use Faker\Generator as Faker;

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' =>  $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('321321'),
        'mobile' => '03'.rand(10000000,99999999),
        'gender' => $faker->randomElement(['F','M']),
        'city_id' => rand(1,30),
        'role_id' => rand(2,3),
        'remember_token' => str_random(10),
    ];
});
