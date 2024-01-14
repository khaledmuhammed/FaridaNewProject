<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->decimal('discount')->default(0);
            $table->decimal('items_price');
            $table->decimal('shipping_price');
            $table->decimal('payment_price');
            $table->decimal('vat');
            $table->decimal('total_price');

            $table->string('shipping_method');
            $table->string('address_owner');
            $table->text('address_details')->nullable();
            $table->string('coupon_code')->nullable();

            $table->string('email')->nullable();
            $table->string('mobile');
            $table->string('username');

            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('address_id')->nullable();
            $table->unsignedInteger('coupon_id')->nullable();
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('shipping_method_id');
            $table->unsignedInteger('payment_method_id');

            $table->foreign('user_id')->references('id')->on("users")->onDelete('restrict');
            $table->foreign('address_id')->references('id')->on("addresses")->onDelete('restrict');
            $table->foreign('city_id')->references('id')->on("cities")->onDelete('restrict');

            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('restrict');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('restrict');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
