<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestquestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testquestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('quizname');
            $table->string('subject');
            $table->string('questionType');
            $table->string('title');
            $table->unsignedBigInteger('teacher_id');
            $table->string('option1');
            $table->string('option2');
            $table->string('option3')->nullable();
            $table->string('correct_answer');
            $table->timestamps();
        
            $table->foreign('teacher_id')->references('id')->on('users'); 
            $table->foreign('subject_id')->references('id')->on('add_subjects');
            $table->foreign('quizname')->references('quizname')->on('papers');



        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testquestions');
    }
}
