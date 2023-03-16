<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreNurseryExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_nursery_exams', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('category');
            $table->Integer('value');
            $table->string('session');
            $table->string('term');
            $table->Integer('student_id');
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
        Schema::dropIfExists('pre_nursery_exams');
    }
}
