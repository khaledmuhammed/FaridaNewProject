<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            ['name' => 'ignored', 'name_ar' => 'مهمل'],
            ['name' => 'canceled', 'name_ar' => 'ملغي'],
            ['name' => 'pending', 'name_ar' => 'معلق'],
            ['name' => 'payment failed', 'name_ar' => 'فشل الدفع'],
            ['name' => 'validating', 'name_ar' => 'جارِ التحقق'],
            ['name' => 'preparing', 'name_ar' => 'جارٍ التجهيز'],
            ['name' => 'shipping', 'name_ar' => 'تم الشحن'],
            ['name' => 'delivered', 'name_ar' => 'تم التسليم'],
        ]);
    }
}
