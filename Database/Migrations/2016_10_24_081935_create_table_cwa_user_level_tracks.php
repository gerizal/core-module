<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCwaUserLevelTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cwa_user_level_tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('userlevel_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('cwa_users')->onDelete('cascade');
            $table->foreign('userlevel_id')->references('id')->on('cwa_user_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cwa_user_level_tracks');
    }
}
