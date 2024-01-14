<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('title');
            $table->string('couponable_type')->nullable();
            $table->unsignedDecimal('amount');
            $table->enum('calc', ['fixed', 'percent']);
            $table->enum('type', ['order', 'product']);
            $table->unsignedDecimal('minimum')->default(0);
            $table->unsignedInteger('usage_limit')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
