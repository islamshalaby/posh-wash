<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('time_id')->unsigned();
            $table->foreign('time_id')->references('id')->on('day_times')->onDelete('restrict');
            $table->bigInteger('order_details_id')->unsigned();
            $table->foreign('order_details_id')->references('id')->on('order_details')->onDelete('restrict');
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
        Schema::dropIfExists('order_times');
    }
}
