<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('question_id');
            $table->mediumText('question_text');
            $table->mediumText('question_answer_explanation');

            $table->bigInteger('subject_id')->unsigned();
            $table->foreign('subject_id')->references('subject_id')->on('subjects');

            $table->bigInteger('chapter_id')->unsigned();
            $table->foreign('chapter_id')->references('chapter_id')->on('chapters');

            $table->enum('question_rating', ['1', '2', '3', '4']);

            $table->bigInteger('institute_id')->unsigned();
            $table->foreign('institute_id')->references('institute_id')->on('institutes');

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
        Schema::dropIfExists('questions');
    }
}
