<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDvaBreakdownSerPrevsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dva_breakdown_ser_prev', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');   
            $table->string('serrprevparticulars');
            $table->string('serrprevcountry');
            $table->decimal('serrprevquantity'); 
            $table->decimal('serrprevamount'); 
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
        Schema::dropIfExists('dva_breakdown_ser_prev');
    }
}
