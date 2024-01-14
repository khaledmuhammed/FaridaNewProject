<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Attribute::class, function (Faker $faker) {
    return [
            'name' => $faker->name,
            'attribute_group_id' => rand(1,10),
    ];
});
