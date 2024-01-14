<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
            Schema::create('order_receivers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('receiver_name');
                $table->string('receiver_mobile');
                $table->unsignedInteger('order_id');
                $table->unsignedInteger('city_id');
                $table->timestamps();
    
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('order_receivers');
    }
}
