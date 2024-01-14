<?php

use Illuminate\Database\Seeder;

class ShippingMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_methods')->insert([
            [
                'name'      => 'شحن خارج الرياض',
                'price'     => '45',
                'is_active' => 1,
            ],
            [
                'name'      => 'توصيل داخل الرياض فقط',
                'price'     => '0',
                'is_active' => 1,
            ]
        ]);
    }
}
