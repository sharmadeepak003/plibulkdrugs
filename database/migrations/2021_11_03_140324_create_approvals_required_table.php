<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsRequiredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals_required', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->text('reqapproval')->nullable();
            $table->text('concernbody')->nullable();
            $table->text('process')->nullable();
            $table->date('dtexpected')->nullable();
            $table->date('dtvalidity')->nullable();
            $table->char('isapproval',1)->nullable();
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
        Schema::dropIfExists('approvals_required');
    }
}
