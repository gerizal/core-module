<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnSentryCwaSettings extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cwa_settings', function (Blueprint $table) {
            $table->integer('sentry');
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
            $table->dropColumn('sentry');
        });
    }
}
