<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrrDvasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrr_dva', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->decimal('EPprevquant'); 
            $table->decimal('EPprevsales'); 
            $table->decimal('EPprevamount'); 
            $table->decimal('EPcurrquant'); 
            $table->decimal('EPcurrsales'); 
            $table->decimal('EPcurramount'); 
            $table->decimal('totConprevquant'); 
            $table->decimal('totConprevsales'); 
            $table->decimal('totConprevamount'); 
            $table->decimal('totConcurrquant'); 
            $table->decimal('totConcurrsales'); 
            $table->decimal('totConcurramount'); 
            $table->decimal('matprevquant'); 
            $table->decimal('matprevsales'); 
            $table->decimal('matprevamount'); 
            $table->decimal('matcurrquant'); 
            $table->decimal('matcurrsales'); 
            $table->decimal('matcurramount'); 
            $table->decimal('serprevquant'); 
            $table->decimal('serprevsales'); 
            $table->decimal('serprevamount'); 
            $table->decimal('sercurrquant'); 
            $table->decimal('sercurrsales'); 
            $table->decimal('sercurramount'); 
            $table->decimal('prevDVATotal'); 
            $table->decimal('currDVATotal'); 
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
        Schema::dropIfExists('qrr_dva');
    }
}
