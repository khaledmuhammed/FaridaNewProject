<?php

use Illuminate\Database\Seeder;
use App\Models\ProductsProperty;
use App\Models\ProductsPropertiesValue;

class ProductsPropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = ProductsProperty::create(['name'=>'لون', 'name_en'=>'color', 'type'=>'color']);
        $color->values()->createMany([
            ['value'=>'#0000ff', 'value_en'=>'#0000ff', 'sort_order'=>0],
            ['value'=>'#00ff00', 'value_en'=>'#00ff00', 'sort_order'=>1],
        ]);

        $size = ProductsProperty::create(['name'=>'حجم', 'name_en'=>'size', 'type'=>'selection']);
        $size->values()->createMany([
            ['value'=>'صغير', 'value_en'=>'small', 'sort_order'=>0],
            ['value'=>'متوسط', 'value_en'=>'midum', 'sort_order'=>1],
            ['value'=>'كبير', 'value_en'=>'big', 'sort_order'=>2]
        ]);
    }
}
