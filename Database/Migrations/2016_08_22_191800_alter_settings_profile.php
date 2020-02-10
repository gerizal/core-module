<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSettingsProfile extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('allow_change_email', 20);
                $table->string('allow_change_password', 20);
            });
        }

        if (Schema::hasTable('cwa_settings')) {
            Schema::table('cwa_settings', function (Blueprint $table) {
                $table->string('allow_change_email', 20);
                $table->string('allow_change_password', 20);
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
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function ($table) {
                $table->dropColumn('allow_change_email');
                $table->dropColumn('allow_change_password');
            });
        }

        if (Schema::hasTable('cwa_settings')) {
            Schema::table('cwa_settings', function ($table) {
                $table->dropColumn('allow_change_email');
                $table->dropColumn('allow_change_password');
            });
        }
    }
}
