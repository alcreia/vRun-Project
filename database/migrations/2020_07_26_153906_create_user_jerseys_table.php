<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJerseysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_jerseys', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->char('jersey_size',5);
            $table->foreign('jersey_size')->references('size')->on('jersey')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_jerseys', function (Blueprint $table) {
            $table->dropForeign('user_jerseys_users_id_foreign');
            $table->dropForeign('user_jerseys_jersey_size_foreign');
        });
        Schema::dropIfExists('user_jerseys');
    }
}
