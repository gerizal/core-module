<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnLimitCwaUserLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('cwa_user_levels')) {
            Schema::table('cwa_user_levels', function (Blueprint $table) {
                $table->integer('time_limit');
            });
        }

        if (Schema::hasTable('user_levels')) {
            Schema::table('user_levels', function (Blueprint $table) {
                $table->integer('time_limit');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('cwa_user_levels')) {
            Schema::table('cwa_user_levels', function ($table) {
                $table->dropColumn('time_limit');
            });
        }

        if (Schema::hasTable('user_levels')) {
            Schema::table('user_levels', function ($table) {
                $table->dropColumn('time_limit');
            });
        }
    }
}
