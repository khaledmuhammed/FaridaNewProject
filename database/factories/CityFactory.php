<?php

use Faker\Generator as Faker;

$factory->define(App\Models\City::class, function (Faker $faker) {
    return [
        'name'       => $faker->city,
        'name_ar'    => $faker->city,
        'country_id' => rand(1,30),
    ];
});
