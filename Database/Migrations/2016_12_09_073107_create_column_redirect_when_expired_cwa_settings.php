<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnRedirectWhenExpiredCwaSettings extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cwa_settings', function (Blueprint $table) {
            $table->string('redirect_when_expired');
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
            $table->dropColumn('redirect_when_expired');
        });
    }
}
