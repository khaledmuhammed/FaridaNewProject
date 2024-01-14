<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Models\Country::class)->create([
        'name' => 'Saudi Arabia',
        'name_ar' => 'المملكة العربية السعودية',
      ]);
      
      // if(App::isLocal()){ // testing seeders
      //   factory(App\Models\Country::class, 40)->create();
      // } else {
      //   factory(App\Models\Country::class)->create([
      //     'name' => 'Saudi Arabia',
      //     'name_ar' => 'المملكة العربية السعودية',
      //   ]);
      // }
    }
}
