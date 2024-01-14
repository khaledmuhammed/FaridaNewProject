<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductAttribute::class, function (Faker $faker) {
    return [
            'text' => $faker->name,
            'attribute_id' => rand(1,10),
            'product_id' => rand(1,5),
    ];
});
