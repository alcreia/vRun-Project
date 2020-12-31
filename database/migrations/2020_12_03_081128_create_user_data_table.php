<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('age');
            $table->char('gender');
            $table->string('angkatan')->default("Umum");
            $table->string('alamat');
            $table->string('phone');
            $table->char('jersey')->references('size')->on('jersey')->nullable();
            $table->bigInteger('donate')->references('id')->on('donations')->nullable();
            $table->char('race_type')->references('id')->on('race_category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data');
    }
}
