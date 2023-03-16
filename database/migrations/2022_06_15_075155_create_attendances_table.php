<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('studentid');
            $table->string('no_of_times_school_opened')->nullable();
            $table->string('no_of_times_present')->nullable();
            $table->string('no_of_times_absent')->nullable();
            $table->string('no_of_times_late')->nullable();
            $table->string('no_of_times_absent_from_drills')->nullable();
            $table->string('session');
            $table->string('term');
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
        Schema::dropIfExists('attendances');
    }
}
