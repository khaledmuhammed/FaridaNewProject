<?php

use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filter = \App\Models\Filter::create([
            'name'    => 'Color',
            'name_ar' => 'اللون',
        ]);


        $filter->options()->saveMany(
            [
                new \App\Models\FilterOption(['name' => 'Red', 'name_ar' => 'أحمر']),
                new \App\Models\FilterOption(['name' => 'Orange', 'name_ar' => 'برتقالي']),
                new \App\Models\FilterOption(['name' => 'White', 'name_ar' => 'أبيض']),
            ]
        );
    }
}
