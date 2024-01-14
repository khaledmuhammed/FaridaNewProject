<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Address::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'city_id' => rand(1,30),
        'user_id' => rand(1,30),
        'details' => $faker->text(100),
    ];

});
