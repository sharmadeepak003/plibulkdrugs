<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_details', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->string('prop_man_add');
            $table->string('prop_man_det');
            $table->string('exst_man_add');
            $table->date('prod_date');
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
        Schema::dropIfExists('proposal_details');
    }
}
