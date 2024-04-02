<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrr_uploads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qrr_id');
            $table->bigInteger('doc_id');
            $table->foreign('doc_id')->references('doc_id')->on('qrr_upload_master');
            $table->string('file_name',200);
            $table->string('mime',200);
            $table->bigInteger('file_size');
            $table->binary('uploaded_file');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('qrr_uploads');
    }
}
