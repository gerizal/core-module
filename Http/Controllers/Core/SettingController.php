<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;

use Mail;
use Input;
use Response;
use Nwidart\Modules\Routing\Controller;

use Modules\Core\Helpers\SettingHelper;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
        $this->middleware('administrator');
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $setting        = SettingHelper::setting();
        $logoOriginal   = SettingHelper::logo();
        $logoMedium     = SettingHelper::logo('medium');
        $logoThumbnail  = SettingHelper::logo('thumb');

        $protocol       = 'http';
        if (isset($_SERVER['REQUEST_SCHEME'])) {
            $protocol   = $_SERVER['REQUEST_SCHEME'];
        }

        $url            = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

        $uNode     = 'application';
        if (stripos($url, '?apis') !== false) {
            $uNode = 'apis';
        }

        if (stripos($url, '?transactions') !== false) {
            $uNode = 'transactions';
        }

        if (stripos($url, '?email') !== false) {
            $uNode = 'email';
        }

        if (stripos($url, '?logging') !== false) {
            $uNode = 'logging';
        }

        if (stripos($url, '?redirects') !== false) {
            $uNode = 'redirects';
        }

        if (stripos($url, '?custom_fields') !== false) {
            $uNode = 'custom_fields';
        }

        return view(
            'core::core.setting.index',
            compact(
                'setting',
                'uNode',
                'logoOriginal',
                'logoMedium',
                'logoThumbnail'
            )
        );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $setting)
    {
        $this->validate($request, [
            'mailchimp_api_key'                 => 'max:50',
            'getresponse_api_key'               => 'max:50',
            'http_request_forward_url'          => 'max:500',
            'jvzoo_secret'                      => 'max:50',
            'warriorplus_api_key'               => 'max:50',
            'warriorplus_security_key'          => 'max:50',
            'aweber_code'                       => 'max:255',
            'mail_driver'                       => 'max:10',
            'mail_host'                         => 'max:50',
            'mail_port'                         => 'max:10',
            'mail_encryption'                   => 'max:10',
            'mail_username'                     => 'max:50',
            'mail_password'                     => 'max:20',
            'mail_from_name'                    => 'max:255',
            'mail_from_email'                   => 'max:255',
            'application_title'                 => 'max:50',
            'application_logo'                  => 'image',
            'support_link'                      => 'url|max:50',
            'footer_left_text'                  => 'max:255',
            'login_text_above'                  => 'max:125',
            'remember_me_text'                  => 'max:50',
            'button_login_text'                 => 'max:25',
            'link_forgot_password_text'         => 'max:50',
            'forgot_text_above'                 => 'max:125',
            'button_reset_request_text'         => 'max:50',
            'link_login_text'                   => 'max:25',
            'reset_text_above'                  => 'max:125',
            'button_reset_password_text'        => 'max:50',
            'register_text_above'               => 'max:125',
            'button_register_text'              => 'max:25',
            'terms_link'                        => 'url|max:50',
            'button_logout_text'                => 'max:25',
            'link_register_new_membership_text' => 'max:50',
            'master_password'                   => 'max:50'
        ]);

        $rRequest = $request->setting_node;

        if ($rRequest == 'application') :
            $this->updateSettingApplication($request, $setting);
        endif;

        if ($rRequest == 'apis') :
            $this->updateSettingApis($request, $setting);
        endif;

        if ($rRequest == 'transactions') :
            $this->updateSettingTransactions($request, $setting);
        endif;

        if ($rRequest == 'email') :
            $this->updateSettingMail($request, $setting);
        endif;

        if ($rRequest == 'logging') :
            $this->updateSettingLogging($request, $setting);
        endif;

        if ($rRequest == 'redirects') :
            $this->updateSettingRedirects($request, $setting);
        endif;

        if ($rRequest == 'custom_fields') :
            $this->updateSettingUserCustomFields($request, $setting);
        endif;

        $redir = 'setting';
        if ($rRequest != 'application') {
            $redir = 'setting?' . $rRequest;
        }

        return redirect($redir)->with('message', 'Your '.str_replace('_', ' ', $rRequest).' settings was updated.');
    }

    public function updateApplicationLogo()
    {
        $file       = Input::file('application_logo');
        $setting    = SettingHelper::setting();

        $setting->application_logo = $file;
        $setting->update();

        $aO         = SettingHelper::logo();
        $aM         = SettingHelper::logo('medium');
        $aT         = SettingHelper::logo('thumb');

        $aLogo      = [
            'aO' => $aO,
            'aM' => $aM,
            'aT' => $aT
        ];

        return Response::json($aLogo);
    }

    private function updateSettingApplication($request, $setting)
    {
        $setting->application_logo                  = $request->application_logo;
        $setting->application_title                 = $request->application_title;
        $setting->support_link                      = $request->support_link;
        $setting->footer_links                      = $request->footer_links;
        $setting->footer_left_text                  = $request->footer_left_text;
        $setting->login_text_above                  = $request->login_text_above;
        $setting->remember_me_text                  = $request->remember_me_text;
        $setting->button_login_text                 = $request->button_login_text;
        $setting->link_forgot_password_text         = $request->link_forgot_password_text;
        $setting->forgot_text_above                 = $request->forgot_text_above;
        $setting->button_reset_request_text         = $request->button_reset_request_text;
        $setting->link_login_text                   = $request->link_login_text;
        $setting->reset_text_above                  = $request->reset_text_above;
        $setting->button_reset_password_text        = $request->button_reset_password_text;
        $setting->register_text_above               = $request->register_text_above;
        $setting->button_register_text              = $request->button_register_text;
        $setting->terms_link                        = $request->terms_link;
        $setting->button_logout_text                = $request->button_logout_text;
        $setting->link_register_new_membership_text = $request->link_register_new_membership_text;
        $setting->allow_public_signup               = $request->allow_public_signup;
        $setting->maintenance_mode                  = $request->maintenance_mode;

        if (!empty($request->master_password)) {
            $setting->master_password   = bcrypt($request->master_password);
        }

        $setting->allow_reset_password  = $request->allow_reset_password;
        $setting->allow_change_email    = $request->allow_change_email;
        $setting->allow_change_password = $request->allow_change_password;

        $setting->update();
    }

    private function updateSettingApis($request, $setting)
    {
        $setting->mailchimp_api_key     = $request->mailchimp_api_key;
        $setting->getresponse_api_key   = $request->getresponse_api_key;
        $setting->aweber_code           = $request->aweber_code;
        $setting->update();
    }

    private function updateSettingTransactions($request, $setting)
    {
        $setting->http_request_forward_url  = $request->http_request_forward_url;
        $setting->jvzoo_secret              = $request->jvzoo_secret;
        $setting->warriorplus_api_key       = $request->warriorplus_api_key;
        $setting->warriorplus_security_key  = $request->warriorplus_security_key;
        $setting->update();
    }

    private function updateSettingMail($request, $setting)
    {
        $setting->mail_driver       = $request->mail_driver;
        $setting->mail_host         = $request->mail_host;
        $setting->mail_port         = $request->mail_port;
        $setting->mail_encryption   = $request->mail_encryption;
        $setting->mail_username     = $request->mail_username;
        $setting->mail_password     = $request->mail_password;
        $setting->mail_from_name    = $request->mail_from_name;
        $setting->mail_from_email   = $request->mail_from_email;
        $setting->update();
    }

    private function updateSettingLogging($request, $setting)
    {
        $setting->sentry            = $request->sentry;
        $setting->sentry_dsn        = $request->sentry_dsn;
        $setting->sentry_public_dsn = $request->sentry_public_dsn;
        $setting->update();
    }

    public function updateSettingRedirects($request, $setting)
    {
        $setting->logout_redirect       = $request->logout_redirect;
        $setting->redirect_when_expired = $request->redirect_when_expired;
        $setting->update();
    }

    public function updateSettingUserCustomFields($request, $setting)
    {
        $setting->user_custom_fields = $request->user_custom_fields;
        $setting->update();
    }
}
