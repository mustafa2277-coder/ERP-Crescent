<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvGrnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_grn', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grn_no');
            $table->string('bill_no');
            $table->string('vendor_id');
            $table->string('project_id');
            $table->string('wareshouse_id');
            $table->string('grn_date');
            $table->string('grn_validatedby');
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
        Schema::dropIfExists('inv_grn');
    }
}
