<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEligibilityCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eligibility_criteria', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->char('greenfield',1);
            $table->char('bankrupt',1);
            $table->decimal('networth',15,2);
            $table->decimal('dva',15,2);
            $table->char('ut_audit',1);
            $table->char('ut_sales',1);
            $table->char('ut_integrity',1);
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
        Schema::dropIfExists('eligibility_criterias');
    }
}
