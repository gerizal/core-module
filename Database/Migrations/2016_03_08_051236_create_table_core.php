<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->users();
        $this->userPreferences();
        $this->userIntegrations();
        $this->userSubscriptions();
        $this->userEmailTracks();
        $this->userLevels();
        $this->passwordResets();
        $this->settings();
        $this->appearances();
    }

    private function users()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->string('avatar_file_name')->nullable();
            $table->integer('avatar_file_size')->nullable();
            $table->string('avatar_content_type')->nullable();
            $table->timestamp('avatar_updated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    private function userPreferences()
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('is_user_active', 3);
            $table->string('display_notice', 3);
            $table->dateTime('last_logged_in');
            $table->integer('upsell_id');
            $table->string('userlevel_id', 50);
            $table->string('api_key', 50);
            $table->integer('affiliate_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    private function userIntegrations()
    {
        Schema::create('user_integrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('aweber_code', 255);
            $table->string('getresponse_api_key', 50);
            $table->string('mailchimp_api_key', 50);
            $table->string('activecampaign_api_url', 50);
            $table->string('activecampaign_api_key', 150);
            $table->string('madmimi_email', 50);
            $table->string('madmimi_api_key', 50);
            $table->string('constantcontact_api_key', 50);
            $table->string('constantcontact_access_token', 50);
            $table->string('icontact_app_id', 50);
            $table->string('icontact_api_password', 50);
            $table->string('icontact_api_username', 50);
            $table->string('twilio_account_sid', 50);
            $table->string('twilio_auth_token', 50);
            $table->string('twilio_number', 50);
            $table->string('google_client_id', 150);
            $table->string('google_client_secret', 50);
            $table->longText('custom_integrations');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    private function userSubscriptions()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('news', 3);
            $table->string('notifications', 3);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    private function userEmailTracks()
    {
        Schema::create('user_email_tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('email', 255);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    private function userLevels()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    private function passwordResets()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }

    private function settings()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mailchimp_api_key', 50);
            $table->string('getresponse_api_key', 50);
            $table->string('jvzoo_secret', 50);
            $table->string('warriorplus_api_key', 50);
            $table->string('warriorplus_security_key', 50);
            $table->string('aweber_code', 255);
            $table->string('mail_driver', 10);
            $table->string('mail_host', 50);
            $table->string('mail_port', 10);
            $table->string('mail_encryption', 10);
            $table->string('mail_username', 50);
            $table->string('mail_password', 20);
            $table->string('mail_from_name', 50);
            $table->string('mail_from_email', 50);
            $table->string('application_title', 50);
            $table->string('support_link', 50);
            $table->text('footer_links');
            $table->string('footer_left_text', 255);
            $table->string('login_text_above', 125);
            $table->string('remember_me_text', 50);
            $table->string('button_login_text', 20);
            $table->string('link_forgot_password_text', 50);
            $table->string('forgot_text_above', 125);
            $table->string('button_reset_request_text', 50);
            $table->string('link_login_text', 25);
            $table->string('reset_text_above', 125);
            $table->string('button_reset_password_text', 50);
            $table->string('register_text_above', 125);
            $table->string('button_register_text', 25);
            $table->string('terms_link', 50);
            $table->string('button_logout_text', 25);
            $table->string('link_register_new_membership_text', 50);
            $table->string('allow_public_signup', 3);
            $table->string('maintenance_mode', 3);
            $table->string('application_logo_file_name', 255);
            $table->integer('application_logo_file_size');
            $table->string('application_logo_content_type', 255);
            $table->timestamp('application_logo_updated_at');
            $table->timestamps();
        });
    }

    private function appearances()
    {
        Schema::create('appearances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('override_main_header');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('users');
        Schema::drop('user_preferences');
        Schema::drop('user_integrations');
        Schema::drop('user_subscriptions');
        Schema::drop('user_email_tracks');
        Schema::drop('user_levels');
        Schema::drop('password_resets');
        Schema::drop('settings');
        Schema::drop('appearances');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
