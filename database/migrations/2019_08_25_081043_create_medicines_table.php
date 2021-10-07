<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('medicine_type_id');
            $table->unsignedBigInteger('medicine_period_id');
            $table->integer('number');
            $table->timestamp('time');

            $table->foreign('medicine_type_id')->references('id')->on('medicine_types');
            $table->foreign('medicine_period_id')->references('id')->on('medicine_periods');

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
        Schema::dropIfExists('medicines');
    }
}
