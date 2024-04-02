<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->string('comp_const');
            $table->string('bus_profile');
            $table->date('doi');
            $table->string('website');
            $table->char('listed',1);
            $table->string('stock_exchange');
            $table->string('corp_add');
            $table->string('corp_state');
            $table->string('corp_city');
            $table->integer('corp_pin');
            $table->char('bankruptcy',1);
            $table->char('rbi_default',1);
            $table->char('wilful_default',1);
            $table->char('sebi_barred',1);
            $table->integer('cibil_score');
            $table->char('case_pend',1);
            $table->integer('created_by');
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
        Schema::dropIfExists('company_details');
    }
}
