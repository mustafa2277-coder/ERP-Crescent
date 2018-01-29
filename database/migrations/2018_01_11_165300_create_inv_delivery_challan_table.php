<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvDeliveryChallanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_delivery_challan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('delivery_challan_no');
            $table->string('product_id');
            $table->string('warehouse_id');
            $table->string('delivery_challan_date');
            $table->string('delivery_challan_validatedby');
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
        Schema::dropIfExists('inv_delivery_challan');
    }
}
