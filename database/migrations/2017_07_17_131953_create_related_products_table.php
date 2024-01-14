<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_products', function (Blueprint $table) {
            $table->integer('first_product_id')->unsigned();
            $table->integer('second_product_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('related_products', function (Blueprint $table) {
             $table->foreign('first_product_id')->references('id')->on('products')->onDelete('cascade');
             $table->foreign('second_product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_products');
    }
}
