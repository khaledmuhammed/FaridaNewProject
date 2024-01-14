<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positionables', function (Blueprint $table) {
            $table->integer('position_id')->unsigned();
            $table->integer('positionable_id')->unsigned();
            $table->string('positionable_type');
            $table->integer('sort');
            $table->timestamps();
        });
        Schema::table('positionables', function(Blueprint $table){
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positionables');
    }
}
