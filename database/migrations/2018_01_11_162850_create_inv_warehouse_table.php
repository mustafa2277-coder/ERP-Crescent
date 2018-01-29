<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('warehouse_name');
            $table->string('warehouse_code');
            $table->string('warehouse address');
            $table->string('warehouse address2');
            $table->string('warehouse_cityid');
            $table->string('warehouse_stateid');
            $table->string('warehouse_countryid');
            $table->string('warehouse_ph');
            $table->string('warehouse_mobile');
            $table->rememberToken();
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
        Schema::dropIfExists('inv_warehouse');
    }
}
