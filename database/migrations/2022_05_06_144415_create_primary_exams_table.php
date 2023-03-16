<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimaryExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_exams', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('first_ca')->nullable();
            $table->string('second_ca')->nullable();
            $table->string('exam')->nullable();
            $table->string('total')->nullable();
            $table->string('remark')->nullable();
            $table->string('student_id');
            $table->string('grade');
            $table->string('arm')->nullable();
            $table->string('term');
            $table->string('session');
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
        Schema::dropIfExists('primary_exams');
    }
}
