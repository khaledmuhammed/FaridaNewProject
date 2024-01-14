<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active');
            $table->integer('super_category_id')->nullable()->unsigned();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('categories', function (Blueprint $table) {
             $table->foreign('super_category_id')->references('id')->on('categories')->onDelete('SET NULL');
        });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
