<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CartItem::class, function (Faker $faker) {
    return [
         'product_id' => factory(\App\Models\Product::class)->create(),
          'user_id' => \App\Models\User::inRandomOrder()->first()->id,
    ];
});
