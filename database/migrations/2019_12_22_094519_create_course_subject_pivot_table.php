<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSubjectPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_subject_pivot', function (Blueprint $table) {
            $table->bigIncrements('course_subject_pivot_id');

            $table->bigInteger('course_id')->unsigned();
            $table->foreign('course_id')->references('course_id')->on('courses');

            $table->bigInteger('subject_id')->unsigned();
            $table->foreign('subject_id')->references('subject_id')->on('subjects');

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
        Schema::dropIfExists('course_subject_pivot');
    }
}
