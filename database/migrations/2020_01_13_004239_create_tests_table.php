<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{

    //test_id, test_name, test_description, test_course_id, test_start_time, test_end_time, test_duration, test_creation_stage, timestamps
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('test_id');
            $table->string('test_name');
            $table->string('test_description');

            $table->bigInteger('course_id')->unsigned();
            $table->foreign('course_id')->references('course_id')->on('courses');

            $table->dateTime('test_start_time');
            $table->dateTime('test_end_time');
            $table->integer('test_duration');

            $table->bigInteger('institute_id')->unsigned();
            $table->foreign('institute_id')->references('institute_id')->on('institutes');

            $table->integer('positive_marking');
            $table->integer('neutral_marking');
            $table->integer('negative_marking');

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
        Schema::dropIfExists('tests');
    }
}
