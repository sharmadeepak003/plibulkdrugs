<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDvaBreakdownMatPrevsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dva_breakdown_mat_prev', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->string('mattprevparticulars') ;
            $table->string('mattprevcountry');   
            $table->decimal('mattprevquantity');    
            $table->decimal('mattprevamount');
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
        Schema::dropIfExists('dva_breakdown_mat_prev');
    }
}
