<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoreRenameAndPrefix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("users", "cwa_users");
        Schema::rename("user_preferences", "cwa_user_preferences");
        Schema::rename("user_integrations", "cwa_user_integrations");
        Schema::rename("user_subscriptions", "cwa_user_subscriptions");
        Schema::rename("user_email_tracks", "cwa_user_email_tracks");
        Schema::rename("password_resets", "cwa_password_resets");
        Schema::rename("settings", "cwa_settings");
        Schema::rename("appearances", "cwa_appearances");
        Schema::rename("user_levels", "cwa_user_levels");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("cwa_users", "users");
        Schema::rename("cwa_user_preferences", "user_preferences");
        Schema::rename("cwa_user_integrations", "user_integrations");
        Schema::rename("cwa_user_subscriptions", "user_subscriptions");
        Schema::rename("cwa_user_email_tracks", "user_email_tracks");
        Schema::rename("cwa_password_resets", "password_resets");
        Schema::rename("cwa_settings", "settings");
        Schema::rename("cwa_appearances", "appearances");
        Schema::rename("cwa_user_levels", "user_levels");
    }
}
