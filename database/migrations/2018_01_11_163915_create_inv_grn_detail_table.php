<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvGrnDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_grn_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grn_id');
            $table->string('product_id');
            $table->string('product_quantity');
            $table->string('purchased_price');
            $table->string('purchased_currency');
            $table->string('exchange_rate');
            $table->string('price_in_pkr');
             $table->string('sale_price');
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
        Schema::dropIfExists('inv_grn_detail');
    }
}
