<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Position::class)->create([
            'name'    => 'home.under.menu',
            'name_ar' => 'الرئيسية.أسفل.القائمة'
        ]);
        factory(App\Models\Position::class)->create([
            'name'    => 'category.under.filter',
            'name_ar' => 'الأقسام.أسفل.الفلتر'
        ]);
    }
}
