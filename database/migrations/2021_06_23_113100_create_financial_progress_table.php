<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_progress', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->bigInteger('bproInvest');           
            $table->bigInteger('bprevExpense');
            $table->bigInteger('bcurrExpense');
            $table->bigInteger('pproInvest');           
            $table->bigInteger('pprevExpense');
            $table->bigInteger('pcurrExpense');
            $table->bigInteger('lproInvest');           
            $table->bigInteger('lprevExpense');
            $table->bigInteger('lcurrExpense');
            $table->bigInteger('eproInvest');            
            $table->bigInteger('eprevExpense');
            $table->bigInteger('ecurrExpense');
            $table->bigInteger('rdproInvest');            
            $table->bigInteger('rdprevExpense');
            $table->bigInteger('rdcurrExpense');
            $table->bigInteger('efproInvest');            
            $table->bigInteger('efprevExpense');
            $table->bigInteger('efcurrExpense');
            $table->bigInteger('solidproInvest');
            $table->bigInteger('solidprevExpense');
            $table->bigInteger('solidcurrExpense');
            $table->bigInteger('hproInvest');           
            $table->bigInteger('hprevExpense');
            $table->bigInteger('hcurrExpense');
            $table->bigInteger('wsproInvest');            
            $table->bigInteger('wsprevExpense');
            $table->bigInteger('wscurrExpense');
            $table->bigInteger('rwproInvest');           
             $table->bigInteger('rwprevExpense');
            $table->bigInteger('rwcurrExpense');
            $table->bigInteger('dmproInvest');            
            $table->bigInteger('dmprevExpense');
            $table->bigInteger('dmcurrExpense');
            $table->bigInteger('caproInvest');            
            $table->bigInteger('caprevExpense');
            $table->bigInteger('cacurrExpense');
            $table->bigInteger('coproInvest');            
            $table->bigInteger('coprevExpense');
            $table->bigInteger('cocurrExpense');
            $table->bigInteger('boproInvest');            
            $table->bigInteger('boprevExpense');
            $table->bigInteger('bocurrExpense');
            $table->bigInteger('poproInvest');            
            $table->bigInteger('poprevExpense');
            $table->bigInteger('pocurrExpense');
            $table->bigInteger('stproInvest');            
            $table->bigInteger('stprevExpense');
            $table->bigInteger('stcurrExpense');
            $table->bigInteger('misproInvest');
            $table->bigInteger('misprevExpense');
            $table->bigInteger('miscurrExpense');
            $table->bigInteger('totproInvest');
            $table->bigInteger('totprevExpense');
            $table->bigInteger('totcurrExpense');
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
        Schema::dropIfExists('financial_progress');
    }
}
