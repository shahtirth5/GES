<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestQuestionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_question_pivot', function (Blueprint $table) {
            $table->bigIncrements('test_question_pivot_id');

            $table->bigInteger('test_id')->unsigned();
            $table->foreign('test_id')->references('test_id')->on('tests');

            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('question_id')->on('questions');

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
        Schema::dropIfExists('test_question_pivot');
    }
}
