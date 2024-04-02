<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_progress', function (Blueprint $table) {
            $table->id();
            $table->integer('qrr_id');
            $table->string('bArea');
            $table->date('bStartDate');
            $table->date('bCompDate');
            $table->string('bRemarks');
            $table->string('oArea');
            $table->date('oStartDate');
            $table->date('oCompDate');
            $table->string('oRemarks');
            $table->string('cArea');
            $table->date('cStartDate');
            $table->date('cCompDate');
            $table->string('cRemarks');
            $table->string('uArea');
            $table->date('uStartDate');
            $table->date('uCompDate');
            $table->string('uRemarks');
            $table->string('pArea');
            $table->date('pStartDate');
            $table->date('pCompDate');
            $table->string('pRemarks');
            $table->string('lArea');
            $table->date('lStartDate');
            $table->date('lCompDate');
            $table->string('lRemarks');
            $table->string('rArea');
            $table->date('rStartDate');
            $table->date('rCompDate');
            $table->string('rRemarks');
            $table->string('eArea');
            $table->date('eStartDate');
            $table->date('eCompDate');
            $table->string('eRemarks');
            $table->string('sArea');
            $table->date('sStartDate');
            $table->date('sCompDate');
            $table->string('sRemarks');
            $table->string('hArea');
            $table->date('hStartDate');
            $table->date('hCompDate');
            $table->string('hRemarks');
            $table->string('wArea');
            $table->date('wStartDate');
            $table->date('wCompDate');
            $table->string('wRemarks');
            $table->string('rwArea');
            $table->date('rwStartDate');
            $table->date('rwCompDate');
            $table->string('rwRemarks');
            $table->string('swArea');
            $table->date('swStartDate');
            $table->date('swCompDate');
            $table->string('swRemarks');
            $table->string('dmwArea');
            $table->date('dmwStartDate');
            $table->date('dmwCompDate');
            $table->string('dmwRemarks');
            $table->string('caArea');
            $table->date('caStartDate');
            $table->date('caCompDate');
            $table->string('caRemarks');
            $table->string('coArea');
            $table->date('coStartDate');
            $table->date('coCompDate');
            $table->string('coRemarks');
            $table->string('boArea');
            $table->date('boStartDate');
            $table->date('boCompDate');
            $table->string('boRemarks');
            $table->string('pgArea');
            $table->date('pgStartDate');
            $table->date('pgCompDate');
            $table->string('pgRemarks');
            $table->string('stArea');
            $table->date('stStartDate');
            $table->date('stCompDate');
            $table->string('stRemarks');
            $table->string('misArea');
            $table->date('misStartDate');
            $table->date('misCompDate');
            $table->string('misRemarks');
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
        Schema::dropIfExists('physical_progress');
    }
}
