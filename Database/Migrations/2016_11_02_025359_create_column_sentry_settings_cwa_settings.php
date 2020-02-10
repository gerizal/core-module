<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnSentrySettingsCwaSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cwa_settings', function (Blueprint $table) {
            $table->string('sentry_dsn');
            $table->string('sentry_public_dsn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cwa_settings', function (Blueprint $table) {
            $table->dropColumn('sentry_dsn');
            $table->dropColumn('sentry_public_dsn');
        });
    }
}
