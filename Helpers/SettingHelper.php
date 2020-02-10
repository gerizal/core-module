<?php

namespace Modules\Core\Helpers;

use Modules\Core\Setting;

class SettingHelper
{
    public static function setting()
    {
        return Setting::find(1);
    }

    public static function logo($size = 'original')
    {
        switch ($size) {
            case 'thumb':
                $applicationLogo = url(self::setting()->application_logo->url('thumb'));
                break;
            case 'medium':
                $applicationLogo = url(self::setting()->application_logo->url('medium'));
                break;
            default:
                $applicationLogo = url(self::setting()->application_logo->url());
                break;
        }
        return $applicationLogo;
    }

    public static function application_title()
    {
        return self::setting()->application_title;
    }

    public static function mailchimp_api_key()
    {
        return self::setting()->mailchimp_api_key;
    }

    public static function getresponse_api_key()
    {
        return self::setting()->getresponse_api_key;
    }

    public static function http_request_forward_url()
    {
        return self::setting()->http_request_forward_url;
    }

    public static function jvzoo_secret()
    {
        return self::setting()->jvzoo_secret;
    }

    public static function warriorplus_api_key()
    {
        return self::setting()->warriorplus_api_key;
    }

    public static function warriorplus_security_key()
    {
        return self::setting()->warriorplus_security_key;
    }

    public static function aweber_code()
    {
        return self::setting()->aweber_code;
    }

    public static function mail_driver()
    {
        return self::setting()->mail_driver;
    }

    public static function mail_host()
    {
        return self::setting()->mail_host;
    }

    public static function mail_port()
    {
        return self::setting()->mail_port;
    }

    public static function mail_encryption()
    {
        return self::setting()->mail_encryption;
    }

    public static function mail_username()
    {
        return self::setting()->mail_username;
    }

    public static function mail_password()
    {
        return self::setting()->mail_password;
    }

    public static function mail_from_name()
    {
        return self::setting()->mail_from_name;
    }

    public static function mail_from_email()
    {
        return self::setting()->mail_from_email;
    }

    public static function support_link()
    {
        return self::setting()->support_link;
    }

    public static function footer_links()
    {
        $flinks = self::setting()->footer_links;
        $flinkObject = explode("\r\n", $flinks);

        $footerLinks = '';
        if (!empty($flinkObject)) {
            foreach ($flinkObject as $oLink) {
                $obLink = explode("|", $oLink);
                if (!empty($obLink)) {
                    $text = '';
                    if (isset($obLink[0])) {
                        $text = $obLink[0];
                    }

                    $link = '';
                    if (isset($obLink[1])) {
                        $link = $obLink[1];
                    }

                    $newTab = '';
                    if (isset($obLink[2])) {
                        $newTab = 'target="_blank"';
                    }

                    $footerLinks .= '<a href="'.$link.'" '.$newTab.'>'.$text.'</a> &bull; ';
                }
            }
        }
        return trim(rtrim(trim($footerLinks), '&bull;'));
    }

    public static function footer_left_text()
    {
        return self::setting()->footer_left_text;
    }

    public static function login_text_above()
    {
        return self::setting()->login_text_above;
    }

    public static function remember_me_text()
    {
        return self::setting()->remember_me_text;
    }

    public static function button_login_text()
    {
        return self::setting()->button_login_text;
    }

    public static function link_forgot_password_text()
    {
        return self::setting()->link_forgot_password_text;
    }

    public static function forgot_text_above()
    {
        return self::setting()->forgot_text_above;
    }

    public static function button_reset_request_text()
    {
        return self::setting()->button_reset_request_text;
    }

    public static function link_login_text()
    {
        return self::setting()->link_login_text;
    }

    public static function reset_text_above()
    {
        return self::setting()->reset_text_above;
    }

    public static function button_reset_password_text()
    {
        return self::setting()->button_reset_password_text;
    }

    public static function register_text_above()
    {
        return self::setting()->register_text_above;
    }

    public static function button_register_text()
    {
        return self::setting()->button_register_text;
    }

    public static function terms_link()
    {
        return self::setting()->terms_link;
    }

    public static function button_logout_text()
    {
        return self::setting()->button_logout_text;
    }

    public static function link_register_new_membership_text()
    {
        return self::setting()->link_register_new_membership_text;
    }

    public static function allow_public_signup()
    {
        return self::setting()->allow_public_signup;
    }

    public static function maintenance_mode()
    {
        return self::setting()->maintenance_mode;
    }

    public static function master_password()
    {
        return self::setting()->master_password;
    }

    public static function allow_reset_password()
    {
        return self::setting()->allow_reset_password;
    }

    public static function allow_change_email()
    {
        return self::setting()->allow_change_email;
    }

    public static function allow_change_password()
    {
        return self::setting()->allow_change_password;
    }

    public static function sentry()
    {
        return self::setting()->sentry;
    }

    public static function sentry_dsn()
    {
        return self::setting()->sentry_dsn;
    }

    public static function sentry_public_dsn()
    {
        return self::setting()->sentry_public_dsn;
    }

    public static function logout_redirect()
    {
        return self::setting()->logout_redirect;
    }

    public static function redirect_when_expired()
    {
        return self::setting()->redirect_when_expired;
    }

    public static function user_custom_fields()
    {
        return self::setting()->user_custom_fields;
    }
}
