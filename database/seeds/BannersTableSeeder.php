<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();;

        if (App::isLocal()) { // testing seeders
            factory(App\Models\Banner::class, 1)->create([
                'size' => 12
            ])->each(function (App\Models\Banner $banner) use ($faker) {
                $banner->addMedia($faker->image('storage/app/public/', 1920, 600, 'food'))
                       ->withCustomProperties(['link'   => '/',
                                               'sort'   => 0,
                                               'width'  => 1920,
                                               'height' => 600])
                       ->toMediaCollection('banners');
                $banner->addMedia($faker->image('storage/app/public/', 1920, 600, 'food'))
                       ->withCustomProperties(['link'   => '/',
                                               'sort'   => 0,
                                               'width'  => 1920,
                                               'height' => 600])
                       ->toMediaCollection('banners');
                $banner->addMedia($faker->image('storage/app/public/', 1920, 600, 'food'))
                       ->withCustomProperties(['link'   => '/',
                                               'sort'   => 0,
                                               'width'  => 1920,
                                               'height' => 600])
                       ->toMediaCollection('banners');
                $banner->positions()->save(\App\Models\Position::find(1), ['sort' => 0]);

            });
            factory(App\Models\Banner::class, 1)->create([
                'size' => 3
            ])->each(function ($banner) use ($faker) {
                $banner->addMedia($faker->image('storage/app/public/', 600, 600, 'food'))
                       ->withCustomProperties(['link'   => '/',
                                               'sort'   => 0,
                                               'width'  => 600,
                                               'height' => 600])
                       ->toMediaCollection('banners');
                $banner->addMedia($faker->image('storage/app/public/', 600, 600, 'food'))
                       ->withCustomProperties(['link'   => '/',
                                               'sort'   => 0,
                                               'width'  => 600,
                                               'height' => 600])
                       ->toMediaCollection('banners');
                $banner->addMedia($faker->image('storage/app/public/', 600, 600, 'food'))
                       ->withCustomProperties(['link'   => '/',
                                               'sort'   => 0,
                                               'width'  => 600,
                                               'height' => 600])
                       ->toMediaCollection('banners');

            });
        }
    }
}
