<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [

            'name' => $faker->name,
            'product_code' => $faker->name,
            'original_price' => rand(50,100),
            'price_after_discount' => rand(10,45),
            'quantity' => rand(1,9),
            'searched' => rand(0,1000),
            'bought' => rand(0,500),
            'availability' => (bool)rand(0,1),
            'availability_date' => date("Y-m-d H:i:s"),
            'manufacturer_id' => rand(1,10),
            'description' => $faker->realText,
    ];
});
