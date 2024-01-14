<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('product_code');
            $table->decimal('original_price');
            $table->decimal('price_after_discount')->nullable();
            $table->integer('quantity')->unsigned()->default(0);
            $table->integer('searched')->unsigned()->default(0);
            $table->integer('bought')->unsigned()->default(0);
            $table->boolean('availability');
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->date('availability_date');
            $table->string('weight')->nullable();
            $table->integer('manufacturer_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
