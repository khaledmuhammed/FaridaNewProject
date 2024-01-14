<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('type');
          $table->integer('product_id')->unsigned();
          $table->string('product_code')->nullable();
          $table->decimal('original_price')->nullable();
          $table->decimal('price_after_discount')->nullable();
          $table->integer('quantity')->unsigned()->default(0);
          $table->integer('bought')->unsigned()->default(0);
          $table->boolean('availability')->default(0);
          $table->date('availability_date');
          $table->timestamps();
          $table->softDeletes();
        });
        Schema::table('product_options', function (Blueprint $table){
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
          $table->foreign('type')->references('name')->on('option_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_options');
    }
}
