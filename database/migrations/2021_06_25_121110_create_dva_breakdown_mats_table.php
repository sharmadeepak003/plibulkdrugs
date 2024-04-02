<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDvaBreakdownMatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dva_breakdown_mat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->string ('mattparticulars'); 
            $table->string('mattcountry');
            $table->decimal('mattquantity'); 
            $table->decimal('mattamount'); 
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
        Schema::dropIfExists('dva_breakdown_mat');
    }
}
