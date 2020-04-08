<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('angkatan')->references('angkatan')->on('users');
            $table->char('raceType')->references('raceType')->on('users');
            $table->float('jarak',8,2)->nullable();
            $table->binary('image')->nullable();
            $table->dateTime('submit_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
