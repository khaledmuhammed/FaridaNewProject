<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntoPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('into_package', function (Blueprint $table) {
          $table->integer('product_id')->unsigned();
          $table->integer('package_id')->unsigned();
          $table->primary(['product_id','package_id']);
          $table->boolean('free')->nullable();
          $table->timestamps();
      });
      Schema::table('into_package', function (Blueprint $table) {
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
          $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::dropIfExists('into_package');
    }
}
