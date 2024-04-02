<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('mobile',10);
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('type');
            $table->string('pan',10);
            $table->string('cin_llpin',21);
            $table->string('off_add');
            $table->string('off_state');
            $table->string('off_city');
            $table->integer('off_pin',6);
            $table->char('existing_manufacturer',1);
            $table->string('business_desc');
            $table->string('applicant_desc');
            $table->string('target_segment');
            $table->string('eligible_product');
            $table->string('contact_person');
            $table->string('designation');
            $table->string('contact_add');
            $table->char('isotpverified',1);
            $table->char('isactive',1);
            $table->char('isapproved',1);
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
        Schema::dropIfExists('users');
    }
}
