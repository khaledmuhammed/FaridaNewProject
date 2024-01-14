<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('group_packages', function (Blueprint $table) {
          $table->integer('role_id')->unsigned();
          $table->integer('package_id')->unsigned();
          $table->primary(['role_id','package_id']);
          $table->timestamps();
      });
      Schema::table('group_packages', function (Blueprint $table) {
          $table->foreign('role_id')->references('id')->on("roles")->onDelete('cascade');
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
        Schema::dropIfExists('group_packages');
    }
}
