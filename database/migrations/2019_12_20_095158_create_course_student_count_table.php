<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseStudentCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_student_counts', function (Blueprint $table) {
            $table->bigIncrements('course_student_count_id');

            $table->bigInteger('institute_id')->unsigned();
            $table->foreign('institute_id')->references('institute_id')->on('institutes');

            $table->bigInteger('course_id')->unsigned();
            $table->foreign('course_id')->references('course_id')->on('courses');

            $table->integer('max_students_in_course_allowed');
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
        Schema::dropIfExists('course_student_counts');
    }
}
