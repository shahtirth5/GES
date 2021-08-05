<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->bigIncrements('test_result_id');

            $table->bigInteger('test_id')->unsigned();
            $table->foreign('test_id')->references('test_id')->on('tests');

            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('student_id')->on('students');

            $table->integer('marks_scored');
            $table->integer('max_marks');

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
        Schema::dropIfExists('test_results');
    }
}
