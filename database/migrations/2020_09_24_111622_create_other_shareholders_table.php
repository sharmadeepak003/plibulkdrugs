<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherShareholdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_shareholders', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->string('name');
            $table->integer('shares');
            $table->decimal('per',15,2);
            $table->integer('capital');
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
        Schema::dropIfExists('other_shareholders');
    }
}
