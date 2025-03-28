<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadLearningMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload__learning__materials', function (Blueprint $table) {
            $table->id();
            $table->string('subject'); 
            $table->string('attachment_type');
            $table->string('attachment_file');
            $table->string('topic');
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();
            $table->foreign('subject')->references('subject')->on('add_subjects'); 
            $table->foreign('uploaded_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload__learning__materials');
    }
}
