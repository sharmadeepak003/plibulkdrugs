<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBgTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bg_trackers', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->string('bank_name');
            $table->string('branch_address');
            $table->string('bg_no');
            $table->string('bg_amount');
            $table->date('issued_dt');
            $table->date('expiry_dt');
            $table->date('claim_dt');
            $table->string('bg_status');
            $table->string('remark');
            $table->string('submit')->default('Y');
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
        Schema::dropIfExists('bg_trackers');
    }
}
