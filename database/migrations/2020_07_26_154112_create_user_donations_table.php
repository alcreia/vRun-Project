<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_donations', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->foreignId('donations_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_donations', function (Blueprint $table) {
            $table->dropForeign('user_donations_users_id_foreign');
            $table->dropForeign('user_donations_donations_id_foreign');
        });
        Schema::dropIfExists('user_donations');
    }
}
