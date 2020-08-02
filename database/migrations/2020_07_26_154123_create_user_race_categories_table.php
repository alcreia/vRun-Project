<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRaceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_race_categories', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->foreignId('race_category_id')->constrained('race_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_race_categories', function (Blueprint $table) {
            $table->dropForeign('user_race_categories_users_id_foreign');
            $table->dropForeign('user_race_categories_race_category_id_foreign');
        });
        Schema::dropIfExists('user_race_categories');
    }
}
