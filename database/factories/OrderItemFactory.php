<?php

use Faker\Generator as Faker;

$autoIncrement = autoIncrement();
$orders        = \App\Models\Order::all()->pluck('id');
$products      = \App\Models\Product::all()->pluck('id');

$factory->define(App\Models\OrderItem::class,function (Faker $faker) use ($autoIncrement) {
    $autoIncrement->next();
    return [

        'order_id' => $autoIncrement->current(),
        'orderable_id' => $autoIncrement->current(),
        'orderable_type' => \App\Models\Product::class,
        'count'=> rand(1,30),
        'unit_price'=> rand(1,0),
    ];
});

function autoIncrement()
{
    for ($i = 1; $i < 20; $i++) {
        yield $i;
    }
}
