<?php

use Faker\Generator as Faker;

$shipping = randomShipping();
$coupon   = randomCoupon();
$user     = randomUser();

$factory->define(App\Models\Order::class, function (Faker $faker) use ($shipping, $coupon, $user) {

    /*   $shipping->next();
       $coupon->next();
       $user->next();*/

    $shipping = \App\Models\ShippingMethod::inRandomOrder()->first();

    $coupon = \App\Models\Coupon::inRandomOrder()->first();

    $user = \App\Models\User::with('addresses.city')->inRandomOrder()->first();

    return [
        'discount'        => rand(0, 30),
        'items_price'     => 100,
        'shipping_price'  => $shipping->price,
        'payment_price'   => $faker->randomElement([0, 30]),
        'total_price'     => 100 + $shipping->price,
        'vat'             => 1,
        'shipping_method' => $shipping->name,
        'address_owner'   => $faker->name,
        'city_id'         => \App\Models\City::inRandomOrder()->value('id'),
        'address_details' => $faker->address,
        'username'        => $faker->name,
        'email'           => $faker->email,
        'mobile'          => $faker->phoneNumber,
        'coupon_code'     => $coupon->code,
        'user_id'         => null,
        'address_id'         => null,
        'coupon_id'          => $coupon->id,
        'shipping_method_id' => $shipping->id,
        'payment_method_id'  => \App\Models\PaymentMethod::inRandomOrder()->first()->id,
    ];
});

function randomShipping()
{
    $shipping = \App\Models\ShippingMethod::inRandomOrder()->first();
    yield $shipping;
}

function randomCoupon()
{
    $coupon = \App\Models\Coupon::inRandomOrder()->first();
    yield $coupon;
}

function randomUser()
{
    $user = \App\Models\User::with('addresses.city')->inRandomOrder()->first();
    yield $user;
}

