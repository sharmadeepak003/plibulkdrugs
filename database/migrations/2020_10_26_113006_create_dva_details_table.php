<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDvaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dva_details', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->decimal('sal_exp',15,2);
            $table->decimal('oth_exp',15,2);
            $table->decimal('non_orig',15,2);
            $table->decimal('tot_cost',15,2);
            $table->decimal('non_orig_raw',15,2);
            $table->decimal('non_orig_srv',15,2);
            $table->decimal('tot_a',15,2);
            $table->decimal('sales_rev',15,2);
            $table->decimal('dva',15,2);
            $table->string('man_dir');
            $table->string('man_desig');
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
        Schema::dropIfExists('dva_details');
    }
}
