<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->unique();
            $table->string('description');
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users'); // Foreign key column
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
        Schema::dropIfExists('add_subjects');
    }
}
