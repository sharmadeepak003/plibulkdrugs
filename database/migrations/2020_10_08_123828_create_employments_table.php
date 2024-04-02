<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->integer('fy20');
            $table->integer('fy21');
            $table->integer('fy22');
            $table->integer('fy23');
            $table->integer('fy24');
            $table->integer('fy25');
            $table->integer('fy26');
            $table->integer('fy27');
            $table->integer('fy28');
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
        Schema::dropIfExists('employments');
    }
}
