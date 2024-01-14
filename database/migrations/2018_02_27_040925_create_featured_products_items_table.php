<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedProductsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_products_items', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('featured_product_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('featured_products_items', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on("products")->onDelete('cascade');
            $table->foreign('featured_product_id')->references('id')->on('featured_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featured_products_items');
    }
}
