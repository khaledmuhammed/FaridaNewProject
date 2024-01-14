<?php

use Illuminate\Database\Seeder;
use App\Models\OptionType;

class OptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['color','size'];
        foreach ($types as $type) {
          OptionType::create(['name'=>$type]);
        }
        if(App::isLocal()){ // testing seeders
          
        }
    }
}
