<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrrDvaBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrr_dva_breakdown', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->string('mattprevparticulars') ;
            $table->string('mattprevcountry');   
            $table->decimal('mattprevquantity');    
            $table->decimal('mattprevamount');    
            $table->string('serrprevparticulars');
            $table->string('serrprevcountry');
            $table->decimal('serrprevquantity'); 
            $table->decimal('serrprevamount'); 
            $table->string ('mattcurrparticulars'); 
            $table->string('mattcurrcountry');
            $table->decimal('mattcurrquantity'); 
            $table->decimal('mattcurramount'); 
            $table->string('serrcurrparticulars');
            $table->string('serrcurrcountry');
            $table->decimal('serrcurrquantity'); 
            $table->decimal('serrcurramount'); 
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
        Schema::dropIfExists('qrr_dva_breakdown');
    }
}
