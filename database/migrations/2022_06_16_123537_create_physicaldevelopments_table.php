<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicaldevelopmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physicaldevelopments', function (Blueprint $table) {
            $table->id();
            $table->string('initial_height')->nullable();
            $table->string('current_height')->nullable();
            $table->string('initial_weight')->nullable();
            $table->string('current_weight')->nullable();
            $table->string('studentid');
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
        Schema::dropIfExists('physicaldevelopments');
    }
}
