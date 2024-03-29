<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('shipping_price')->default(0);
            $table->unsignedInteger('city_id');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('district_zones');
    }
}
