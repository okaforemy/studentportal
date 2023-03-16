<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimaryAffectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_affectives', function (Blueprint $table) {
            $table->id();
            $table->string('alertness')->default(0);
            $table->string('responsibility')->default(0);
            $table->string('appearance')->default(0);
            $table->string('property')->default(0);
            $table->string('independently')->default(0);
            $table->string('work')->default(0);
            $table->string('honesty')->default(0);
            $table->string('peers')->default(0);
            $table->string('leadership')->default(0);
            $table->string('politeness')->default(0);
            $table->string('confidence')->default(0);
            $table->string('speaking')->default(0);
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
        Schema::dropIfExists('primary_affectives');
    }
}
