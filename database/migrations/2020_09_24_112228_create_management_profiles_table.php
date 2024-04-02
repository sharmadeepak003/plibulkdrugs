<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->string('name');
            $table->string('email');
            $table->bigInteger('phone');
            $table->string('din');
            $table->string('add');
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
        Schema::dropIfExists('management_profiles');
    }
}
