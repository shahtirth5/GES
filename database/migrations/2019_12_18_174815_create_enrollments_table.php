<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->bigIncrements('enrollment_id');
            // Student Id
            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('student_id')->on('students');

            // Institute Id
            $table->bigInteger('institute_id')->unsigned();
            $table->foreign('institute_id')->references('institute_id')->on('institutes');

            // Course Id
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('course_id')->references('course_id')->on('courses');

            // Enrollment Status
            // -1 => rejected
            // 0 => no response yet
            // 1 => accepted
            // 2 => accepted and then rejected
            // 3 => blocked
            $table->enum('enrollment_status', ['-1', '0', '1', '2', '3'])->default('0');

            $table->timestamp('enrollment_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
