<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeansOfFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('means_of_finance', function (Blueprint $table) {
            $table->id();
            $table->integer('qrr_id');
            $table->integer('eAmount');
            $table->string('eStatus');
            $table->string('eRemarks');
            $table->integer('dAmount');
            $table->string('dStatus');
            $table->string('dRemarks');
            $table->integer('iAmount');
            $table->string('iStatus');
            $table->string('iRemarks');
            $table->integer('tAmount');
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
        Schema::dropIfExists('means_of_finances');
    }
}
