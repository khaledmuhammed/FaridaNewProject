<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Manufacturer::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'name_ar' => $faker->name,
    ];
});
