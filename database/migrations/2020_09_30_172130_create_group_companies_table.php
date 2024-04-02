<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_companies', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->string('name');
            $table->string('location');
            $table->string('regno');
            $table->string('relation');
            $table->decimal('networth',15,2);
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
        Schema::dropIfExists('group_companies');
    }
}
