<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupDailyDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('group_daily_deals', function (Blueprint $table) {
          $table->integer('role_id')->unsigned();
          $table->integer('daily_deal_id')->unsigned();
          $table->primary(['role_id','daily_deal_id']);
          $table->timestamps();
      });
      Schema::table('group_daily_deals', function (Blueprint $table) {

          $table->foreign('role_id')->references('id')->on("roles")->onDelete('cascade');
          $table->foreign('daily_deal_id')->references('id')->on('daily_deals')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::dropIfExists('group_daily_deals');
    }
}
