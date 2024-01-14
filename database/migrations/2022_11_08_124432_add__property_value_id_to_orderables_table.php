<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyValueIdToOrderablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderables', function (Blueprint $table) {
            $table->unsignedInteger('property_value_id')->nullable()->after('into_package');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderables', function (Blueprint $table) {
            $table->dropColumn('property_value_id');
        });
    }
}
