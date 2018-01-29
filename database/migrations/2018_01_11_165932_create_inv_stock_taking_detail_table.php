<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvStockTakingDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('inv_stock_taking_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id');
            $table->string('quantity_in_stock');
            $table->string('actual_quantity');
            $table->string('reason_of_diff');
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
        Schema::dropIfExists('inv_stock_taking_detail');
    }
}
