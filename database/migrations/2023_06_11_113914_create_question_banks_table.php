<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->string('paper_name');
            $table->unsignedBigInteger('question_id');
            $table->string('subject_name', 255);
            $table->unsignedBigInteger('subject_id');
            $table->string('question');
            $table->string('question_type');
            $table->string('option1');
            $table->string('option2');
            $table->string('option3')->nullable();
            $table->string('correct_answer');
            $table->tinyInteger('is_answered')->default(0);
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('student_id');
            // Add other necessary fields for the published questions table
            $table->timestamps();

           // $table->foreign('subject_name')->references('subject')->on('testquestions');
            $table->foreign('subject_id')->references('id')->on('add_subjects');
            $table->foreign('question_id')->references('id')->on('testquestions')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users');
            $table->foreign('teacher_id')->references('id')->on('users'); 


           // $table->foreign('paper_name')->references('quizname')->on('papers');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_banks');
    }
}
