<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PaymentMethod::class)->create([
            'name'      =>'بطاقة مدى / بطاقة ائتمان',
            'is_active' =>1
        ]);
        factory(App\Models\PaymentMethod::class)->create([
            'name'      =>'دفع عند الاستلام',
            'is_active' =>1
        ]);
        factory(App\Models\PaymentMethod::class)->create([
            'name'      =>'تحويل بنكي',
            'is_active' =>1
        ]);
    }
}
