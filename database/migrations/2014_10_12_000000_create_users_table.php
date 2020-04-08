<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('gender');
            $table->date('dateOfBirth');
            $table->year('angkatan');
            $table->char('blood');
            $table->char('jersey');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('alamat');
            $table->string('phone');
            $table->char('raceType');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
