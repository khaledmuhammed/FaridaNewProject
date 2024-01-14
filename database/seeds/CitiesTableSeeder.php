<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Models\City::class)->create([
        'name'        => 'Riyadh',
        'name_ar'     => 'الرياض',
        'country_id'  => 1,
      ]);
      // if(App::isLocal()){ // testing seeders
      //   factory(App\Models\City::class, 30)->create();
      // } else {
      //   factory(App\Models\City::class)->create([
      //     'name'        => 'Riyadh',
      //     'name_ar'     => 'الرياض',
      //     'country_id'  => 1,
      //   ]);
      // }
    }
}
