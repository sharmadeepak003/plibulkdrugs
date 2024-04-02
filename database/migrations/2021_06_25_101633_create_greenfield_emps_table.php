<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGreenfieldEmpsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('greenfield_emp', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->bigInteger('laborPrevNo');
            $table->bigInteger('laborCurrNo');
            $table->bigInteger('empPrevNo');
            $table->bigInteger('empCurrNo');
            $table->bigInteger('conPrevNo');
            $table->bigInteger('conCurrNo');
            $table->bigInteger('appPrevNo');
            $table->bigInteger('appCurrNo');
            $table->bigInteger('totPrevNo');
            $table->bigInteger('totCurrNo');
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
        Schema::dropIfExists('greenfield_emp');
    }
}
