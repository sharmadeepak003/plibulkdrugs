<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->decimal('phar_dom_17', 15, 2);
            $table->decimal('phar_dom_18', 15, 2);
            $table->decimal('phar_dom_19', 15, 2);
            $table->decimal('phar_exp_17', 15, 2);
            $table->decimal('phar_exp_18', 15, 2);
            $table->decimal('phar_exp_19', 15, 2);
            $table->decimal('oth_dom_17', 15, 2);
            $table->decimal('oth_dom_18', 15, 2);
            $table->decimal('oth_dom_19', 15, 2);
            $table->decimal('oth_exp_17', 15, 2);
            $table->decimal('oth_exp_18', 15, 2);
            $table->decimal('oth_exp_19', 15, 2);
            $table->decimal('oth_inc_17', 15, 2);
            $table->decimal('oth_inc_18', 15, 2);
            $table->decimal('oth_inc_19', 15, 2);
            $table->decimal('tot_rev_17', 15, 2);
            $table->decimal('tot_rev_18', 15, 2);
            $table->decimal('tot_rev_19', 15, 2);
            $table->decimal('pbt17', 15, 2);
            $table->decimal('pbt18', 15, 2);
            $table->decimal('pbt19', 15, 2);
            $table->decimal('pat17', 15, 2);
            $table->decimal('pat18', 15, 2);
            $table->decimal('pat19', 15, 2);
            $table->decimal('sh_cap_17', 15, 2);
            $table->decimal('sh_cap_18', 15, 2);
            $table->decimal('sh_cap_19', 15, 2);
            $table->decimal('eq_prom_17', 15, 2);
            $table->decimal('eq_prom_18', 15, 2);
            $table->decimal('eq_prom_19', 15, 2);
            $table->decimal('eq_ind_17', 15, 2);
            $table->decimal('eq_ind_18', 15, 2);
            $table->decimal('eq_ind_19', 15, 2);
            $table->decimal('eq_frn_17', 15, 2);
            $table->decimal('eq_frn_18', 15, 2);
            $table->decimal('eq_frn_19', 15, 2);
            $table->decimal('eq_mult_17', 15, 2);
            $table->decimal('eq_mult_18', 15, 2);
            $table->decimal('eq_mult_19', 15, 2);
            $table->decimal('eq_bank_17', 15, 2);
            $table->decimal('eq_bank_18', 15, 2);
            $table->decimal('eq_bank_19', 15, 2);
            $table->decimal('int_acc_17', 15, 2);
            $table->decimal('int_acc_18', 15, 2);
            $table->decimal('int_acc_19', 15, 2);
            $table->decimal('ln_prom_17', 15, 2);
            $table->decimal('ln_prom_18', 15, 2);
            $table->decimal('ln_prom_19', 15, 2);
            $table->decimal('ln_ind_17', 15, 2);
            $table->decimal('ln_ind_18', 15, 2);
            $table->decimal('ln_ind_19', 15, 2);
            $table->decimal('ln_frn_17', 15, 2);
            $table->decimal('ln_frn_18', 15, 2);
            $table->decimal('ln_frn_19', 15, 2);
            $table->decimal('ln_mult_17', 15, 2);
            $table->decimal('ln_mult_18', 15, 2);
            $table->decimal('ln_mult_19', 15, 2);
            $table->decimal('ln_bank_17', 15, 2);
            $table->decimal('ln_bank_18', 15, 2);
            $table->decimal('ln_bank_19', 15, 2);
            $table->decimal('gr_ind_17', 15, 2);
            $table->decimal('gr_ind_18', 15, 2);
            $table->decimal('gr_ind_19', 15, 2);
            $table->decimal('gr_frn_17', 15, 2);
            $table->decimal('gr_frn_18', 15, 2);
            $table->decimal('gr_frn_19', 15, 2);
            $table->char('rnd_unit',1);
            $table->char('rnd_rcnz',1);
            $table->decimal('rnd_inv_17', 15, 2);
            $table->decimal('rnd_inv_18', 15, 2);
            $table->decimal('rnd_inv_19', 15, 2);
            $table->char('rnd_achv',1);
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
        Schema::dropIfExists('financials');
    }
}
