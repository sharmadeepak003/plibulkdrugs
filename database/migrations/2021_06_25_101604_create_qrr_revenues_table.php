<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrrRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrr_revenue', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->decimal('gcDomPrevQuantity');        
            $table->decimal('gcDomPrevSales');
            $table->decimal('gcDomCurrQuantity');
            $table->decimal('gcDomCurrSales');         
            $table->decimal('gcExpPrevQuantity');
            $table->decimal('gcExpPrevSales');
            $table->decimal('gcExpCurrQuantity');         
            $table->decimal('gcExpCurrSales');
            $table->decimal('gcCapPrevQuantity');
            $table->decimal('gcCapPrevSales');          
            $table->decimal('gcCapCurrQuantity');
            $table->decimal('gcCapCurrSales');         
            $table->decimal('gcTotPrevQuantity');
            $table->decimal('gcTotPrevSales');
            $table->decimal('gcTotCurrQuantity');         
            $table->decimal('gcTotCurrSales');
            $table->decimal('ecDomPrevQuantity');
            $table->decimal('ecDomPrevSales');        
            $table->decimal('ecDomCurrQuantity');
            $table->decimal('ecDomCurrSales');
            $table->decimal('ecExpPrevQuantity');         
            $table->decimal('ecExpPrevSales');
            $table->decimal('ecExpCurrQuantity');        
            $table->decimal('ecExpCurrSales');
            $table->decimal('ecCapPrevQuantity');
            $table->decimal('ecCapPrevSales');        
            $table->decimal('ecCapCurrQuantity');
            $table->decimal('ecCapCurrSales');
            $table->decimal('ecTotPrevQuantity');        
            $table->decimal('ecTotPrevSales');
            $table->decimal('ecTotCurrQuantity');
            $table->decimal('ecTotCurrSales');          
            $table->decimal('otDomPrevQuantity');
            $table->decimal('otDomPrevSales');         
            $table->decimal('otDomCurrQuantity');
            $table->decimal('otDomCurrSales');
            $table->decimal('otExpPrevQuantity');         
            $table->decimal('otExpPrevSales');
            $table->decimal('otExpCurrQuantity');
            $table->decimal('otExpCurrSales');         
            $table->decimal('otCapPrevQuantity');
            $table->decimal('otCapPrevSales');
            $table->decimal('otCapCurrQuantity');          
            $table->decimal('otCapCurrSales');
            $table->decimal('otTotPrevQuantity');         
            $table->decimal('otTotPrevSales');
            $table->decimal('otTotCurrQuantity');
            $table->decimal('otTotCurrSales');         
            $table->decimal('otherPrevQuantity');
            $table->decimal('otherPrevSales');
            $table->decimal('otherCurrQuantity');         
            $table->decimal('otherCurrSales');
            $table->decimal('totPrevQuantity');
            $table->decimal('totPrevSales'     );          
            $table->decimal('totCurrQuantity');
            $table->decimal('totCurrSales');  
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
        Schema::dropIfExists('qrr_revenue');
    }
}
