<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityShippingMethod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_shipping_method',function (Blueprint $table){
           $table->increments('id');
           $table->unsignedInteger('city_id');
           $table->unsignedInteger('shipping_method_id');
           $table->boolean('has_cash_on_delivery')->default(false);
        });

        Schema::table('city_shipping_method', function (Blueprint $table){

            $table->foreign('city_id')->references('id')->on("cities")->onDelete('cascade');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_shipping_method');
    }
}
