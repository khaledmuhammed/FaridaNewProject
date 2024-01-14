<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rating');
            $table->string('comment');
            $table->boolean('approved');
            $table->integer('user_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->unique(['user_id','product_id']);
            $table->timestamps();
        });
        Schema::table('ratings', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on("users")->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
