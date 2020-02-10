<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessengerThemeToAppearanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appearances', function (Blueprint $table) {
            $table->string('messenger_theme', 28);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appearances', function (Blueprint $table) {
            $table->dropColumn('messenger_theme');
        });
    }
}
