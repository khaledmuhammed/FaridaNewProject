<?php

use Illuminate\Database\Seeder;
use App\Models\Block;

class BlocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $block = new Block;
        $block->title = 'المنتج 1';
        $block->description = '';
        $block->text_button = 'تسوق الآن';
        $block->link_button = '/';
        $block->save();
    }
}
