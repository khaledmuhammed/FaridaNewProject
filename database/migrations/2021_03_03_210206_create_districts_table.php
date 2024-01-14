<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('district_zone_id');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('RESTRICT');
            $table->foreign('district_zone_id')->references('id')->on('district_zones')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
