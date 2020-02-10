<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;
use Illuminate\Support\Facades\DB;

class Seeder implements SetupScript
{
    /**
     * Fire the install script
     * @param  Command $command
     * @return mixed
     */
    public function fire(Command $command)
    {
        if ($command->option('verbose')) {
            $command->blockMessage('Seeding', 'Starting the database seeding ...', 'comment');
        }

        $user = DB::table('cwa_users')->where('id', 1)->first();
        if ($user == null) {
            DB::transaction(function () {
                $this->seedUserLevels();
                $this->seedUsers();
                $this->seedUserPreferences();
                $this->seedUserIntegrations();
                $this->seedUserSubscriptions();
                $this->seedSettings();
                $this->seedAppearances();
                $this->seedUserLevelTracks();
            });
        }
    }

    /**
     * User Levels
     */
    private function seedUserLevels()
    {
        $userLevels = [
            [
                'name'          => 'Administrator',
                'slug'          => 'administrator',
                'redirect'      => '/user',
                'features'      => 'ALL_FEATURES',
                'time_limit'    => 0,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'name'          => 'Normal User',
                'slug'          => 'normaluser',
                'redirect'      => '/start',
                'features'      => 'ALL_FEATURES',
                'time_limit'    => 0,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('cwa_user_levels')->insert($userLevels);
    }

    /**
     * Users
     */
    private function seedUsers()
    {
        $users = [
            [
                'name'                  => 'Administrator',
                'email'                 => 'admin@stickyviral.com',
                'password'              => bcrypt('secret'),
                'avatar_file_name'      => 'admin.png',
                'avatar_file_size'      => 67363,
                'avatar_content_type'   => 'image/png',
                'avatar_updated_at'     => date('Y-m-d H:i:s'),
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s')
            ],
            [
                'name'                  => 'Normal User',
                'email'                 => 'normaluser@stickyviral.com',
                'password'              => bcrypt('secret'),
                'avatar_file_name'      => 'admin.png',
                'avatar_file_size'      => 67363,
                'avatar_content_type'   => 'image/png',
                'avatar_updated_at'     => date('Y-m-d H:i:s'),
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('cwa_users')->insert($users);
    }

    /**
     * User Preferences
     */
    private function seedUserPreferences()
    {
        $userPreferences = [
            [
                'user_id'           => 1,
                'is_user_active'    => 'YES',
                'display_notice'    => 'YES',
                'userlevel_id'      => '["1"]',
                'api_key'           => str_random(32),
                'last_logged_in'    => date('Y-m-d H:i:s'),
                'upsell_id'         => 0,
                'affiliate_id'      => 0,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s')
            ],
            [
                'user_id'           => 2,
                'is_user_active'    => 'YES',
                'display_notice'    => 'YES',
                'userlevel_id'      => '["2"]',
                'api_key'           => str_random(32),
                'last_logged_in'    => date('Y-m-d H:i:s'),
                'upsell_id'         => 0,
                'affiliate_id'      => 0,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('cwa_user_preferences')->insert($userPreferences);
    }

    /**
     * User Integrations
     */
    private function seedUserIntegrations()
    {
        $userIntegrations = [
            [
                'user_id'                       => 1,
                'aweber_code'                   => '',
                'getresponse_api_key'           => '',
                'mailchimp_api_key'             => '',
                'activecampaign_api_url'        => '',
                'activecampaign_api_key'        => '',
                'madmimi_email'                 => '',
                'madmimi_api_key'               => '',
                'constantcontact_api_key'       => '',
                'constantcontact_access_token'  => '',
                'icontact_app_id'               => '',
                'icontact_api_password'         => '',
                'icontact_api_username'         => '',
                'twilio_account_sid'            => '',
                'twilio_auth_token'             => '',
                'twilio_number'                 => '',
                'google_client_id'              => '',
                'google_client_secret'          => '',
                'custom_integrations'           => '',
                'created_at'                    => date('Y-m-d H:i:s'),
                'updated_at'                    => date('Y-m-d H:i:s')
            ],
            [
                'user_id'                       => 2,
                'aweber_code'                   => '',
                'getresponse_api_key'           => '',
                'mailchimp_api_key'             => '',
                'activecampaign_api_url'        => '',
                'activecampaign_api_key'        => '',
                'madmimi_email'                 => '',
                'madmimi_api_key'               => '',
                'constantcontact_api_key'       => '',
                'constantcontact_access_token'  => '',
                'icontact_app_id'               => '',
                'icontact_api_password'         => '',
                'icontact_api_username'         => '',
                'twilio_account_sid'            => '',
                'twilio_auth_token'             => '',
                'twilio_number'                 => '',
                'google_client_id'              => '',
                'google_client_secret'          => '',
                'custom_integrations'           => '',
                'created_at'                    => date('Y-m-d H:i:s'),
                'updated_at'                    => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('cwa_user_integrations')->insert($userIntegrations);
    }

    /**
     * User Subscriptions
     */
    private function seedUserSubscriptions()
    {
        $userSubscriptions = [
            [
                'user_id'       => 1,
                'news'          => 'YES',
                'notifications' => 'YES',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'user_id'       => 2,
                'news'          => 'YES',
                'notifications' => 'YES',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('cwa_user_subscriptions')->insert($userSubscriptions);
    }

    /**
     * Settings
     */
    private function seedSettings()
    {
        DB::table('cwa_settings')->insert([
            'id'                                => 1,
            'mail_driver'                       => 'mail',
            'mail_host'                         => '',
            'mail_port'                         => '',
            'mail_encryption'                   => 'tls',
            'mail_username'                     => '',
            'mail_from_name'                    => 'Core Web App',
            'mail_from_email'                   => '',
            'application_title'                 => 'Core Web App',
            'support_link'                      => 'http://support.rapidproductstudio.com',
            'footer_links'                      => 'Support|http://support.rapidproductstudio.com|newtab',
            'footer_left_text'                  => 'Copyright &copy; 2017. Rapid Product Studio.',
            'login_text_above'                  => 'Login here',
            'remember_me_text'                  => 'Remember me',
            'button_login_text'                 => 'Login',
            'link_forgot_password_text'         => 'Forgot password',
            'forgot_text_above'                 => 'I forgot my password',
            'button_reset_request_text'         => 'Send me the reset link',
            'link_login_text'                   => 'Login again',
            'reset_text_above'                  => 'Reset password',
            'button_reset_password_text'        => 'Reset my password',
            'register_text_above'               => 'Register',
            'button_register_text'              => 'Register',
            'terms_link'                        => 'http://tos.rapidproductstudio.com',
            'button_logout_text'                => 'Logout',
            'link_register_new_membership_text' => 'Request new membership?',
            'allow_public_signup'               => 'YES',
            'maintenance_mode'                  => 'NO',
            'application_logo_file_name'        => 'logo.png',
            'application_logo_file_size'        => 7966,
            'application_logo_content_type'     => 'image/png',
            'application_logo_updated_at'       => date('Y-m-d H:i:s'),
            'created_at'                        => date('Y-m-d H:i:s'),
            'updated_at'                        => date('Y-m-d H:i:s'),
            'mailchimp_api_key'                 => '',
            'getresponse_api_key'               => '',
            'jvzoo_secret'                      => '',
            'warriorplus_api_key'               => '',
            'warriorplus_security_key'          => '',
            'aweber_code'                       => '',
            'mail_password'                     => '',
            'allow_reset_password'              => 'YES',
            'http_request_forward_url'          => '',
            'master_password'                   => '',
            'allow_change_email'                => 'NO',
            'allow_change_password'             => 'YES',
            'sentry'                            => 0,
            'sentry_dsn'                        => '',
            'sentry_public_dsn'                 => '',
            'logout_redirect'                   => '',
            'redirect_when_expired'             => '',
        ]);
    }

    /**
     * Appearances
     */
    private function seedAppearances()
    {
        DB::table('cwa_appearances')->insert([
            'override_main_header'  => 0,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
            'skin'                  => 'skin-black',
            'messenger_theme'       => 'ice'
        ]);
    }

    /**
     * User Level Tracks
     */
    private function seedUserLevelTracks()
    {
        $userLevelTracks = [
            [
                'user_id'       => 1,
                'userlevel_id'  => 1,
                'start_date'    => date('Y-m-d H:i:s'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'user_id'       => 2,
                'userlevel_id'  => 2,
                'start_date'    => date('Y-m-d H:i:s'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];
        DB::table('cwa_user_level_tracks')->insert($userLevelTracks);
    }
}
