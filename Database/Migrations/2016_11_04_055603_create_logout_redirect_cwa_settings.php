<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogoutRedirectCwaSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cwa_settings', function (Blueprint $table) {
            $table->string('logout_redirect');
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
            $table->dropColumn('logout_redirect');
        });
    }
}
