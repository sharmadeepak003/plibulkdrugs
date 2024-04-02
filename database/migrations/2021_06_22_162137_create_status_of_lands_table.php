<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusOfLandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_of_land', function (Blueprint $table) {
            $table->id();
            $table->integer('qrr_id');
            $table->integer('mid');
            $table->integer('area');
            $table->string('freeleash');
            $table->string('acqusition');
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
        Schema::dropIfExists('status_of_lands');
    }
}
