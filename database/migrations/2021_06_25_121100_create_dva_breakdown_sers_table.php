<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDvaBreakdownSersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dva_breakdown_ser', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->string('serrparticulars');
            $table->string('serrcountry');
            $table->decimal('serrquantity'); 
            $table->decimal('serramount'); 
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
        Schema::dropIfExists('dva_breakdown_ser');
    }
}
