<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestSelectedQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_selected_questions', function (Blueprint $table) {
            $table->bigIncrements('test_selected_question_id');

            $table->bigInteger('test_session_id')->unsigned();
            $table->foreign('test_session_id')->references('test_session_id')->on('test_sessions');

            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('question_id')->on('questions');

            $table->bigInteger('selected_option_id')->unsigned()->nullable();
            $table->foreign('selected_option_id')->references('option_id')->on('options');

            $table->enum('status', ['0','1','2']); // 0 => not attempted, 1 => submitted, 2 => tagged

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
        Schema::dropIfExists('test_selected_questions');
    }
}
