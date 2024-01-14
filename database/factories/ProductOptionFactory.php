<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductOption::class, function (Faker $faker) {
    return [
      'name'                  => $faker->name,
      'product_code'          => $faker->optional()->name,
      'original_price'        => array_random([null,rand(50,100)]),
      'price_after_discount'  => array_random([null,rand(10,45)]),
      'quantity'              => rand(0,9),
      'bought'                => rand(0,500),
      'availability'          => (bool)rand(0,1),
      'availability_date'     => date("Y-m-d H:i:s"),
      'type'                  => \App\Models\OptionType::inRandomOrder()->first()->name,
    ];
});
