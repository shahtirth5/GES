<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->bigIncrements('test_session_id');

            $table->bigInteger('test_id')->unsigned();
            $table->foreign('test_id')->references('test_id')->on('tests');

            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('student_id')->on('students');

            $table->integer('session_timer');

            $table->enum('session_status', ['-1','0','1']); // -1 => closed, 0 => yet to be opened, 1 => opened

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
        Schema::dropIfExists('test_session');
    }
}
