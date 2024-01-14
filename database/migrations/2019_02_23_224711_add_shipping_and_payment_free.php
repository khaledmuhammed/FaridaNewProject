<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShippingAndPaymentFree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('shipping_free')->default(0);
            $table->boolean('payment_free')->default(0);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('shipping_free')->default(0);
            $table->boolean('payment_free')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
