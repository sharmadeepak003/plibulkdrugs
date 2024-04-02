<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funding_details', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->integer('prt_id');
            $table->decimal('prom',15,2);
            $table->decimal('banks',15,2);
            $table->decimal('others',15,2);
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
        Schema::dropIfExists('funding_details');
    }
}
