<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondaryAffectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondary_affectives', function (Blueprint $table) {
            $table->id();
            $table->string('alertness');
            $table->string('responsibility');
            $table->string('appearance');
            $table->string('property');
            $table->string('independently');
            $table->string('work');
            $table->string('honesty');
            $table->string('peers');
            $table->string('leadership');
            $table->string('politeness');
            $table->string('confidence');
            $table->string('speaking');
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
        Schema::dropIfExists('secondary_affectives');
    }
}
