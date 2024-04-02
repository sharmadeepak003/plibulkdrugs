<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->decimal('expfy20', 15, 2);
            $table->decimal('expfy21', 15, 2);
            $table->decimal('expfy22', 15, 2);
            $table->decimal('expfy23', 15, 2);
            $table->decimal('expfy24', 15, 2);
            $table->decimal('expfy25', 15, 2);
            $table->decimal('expfy26', 15, 2);
            $table->decimal('expfy27', 15, 2);
            $table->decimal('expfy28', 15, 2);
            $table->decimal('domfy20', 15, 2);
            $table->decimal('domfy21', 15, 2);
            $table->decimal('domfy22', 15, 2);
            $table->decimal('domfy23', 15, 2);
            $table->decimal('domfy24', 15, 2);
            $table->decimal('domfy25', 15, 2);
            $table->decimal('domfy26', 15, 2);
            $table->decimal('domfy27', 15, 2);
            $table->decimal('domfy28', 15, 2);
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
        Schema::dropIfExists('revenues');
    }
}
