<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('user_levels', function ($table) {
            $table->text('features');
        });

        Schema::create('features', function ($table) {
            $table->increments('id');
            $table->string("tag", 50)->unique();
            $table->string("description");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('user_levels', function ($table) {
            $table->dropColumn('features');
        });

        Schema::drop('features');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
