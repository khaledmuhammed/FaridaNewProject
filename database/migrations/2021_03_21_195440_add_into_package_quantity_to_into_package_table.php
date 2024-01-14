<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIntoPackageQuantityToIntoPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('into_package', function (Blueprint $table) {
            $table->unsignedInteger('into_package_quantity')->default(1)->after('free');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('into_package', function (Blueprint $table) {
            //
        });
    }
}
