<?php

namespace Modules\Core\Helpers;

use Mail;
use Modules\Hook\Hook;
use Modules\EmailHook\EmailHook;
use Modules\Core\Helpers\SettingHelper;

class MailHelper
{
    /**
    * Send email
    */
    public static function send($hook, $parameters)
    {
        $hookObject         = Hook::where('hook', '=', $hook)->first();
        if (empty($hookObject)) {
            // Skip if the hook not configured
            return;
        }

        $messageToSend      = self::buildMessage($hook, $parameters);
        $messageSubject     = $messageToSend->subject;
        $messageBody        = $messageToSend->body;
        $email              = $parameters->email;

        $data               = array();
        $data['content']    = $messageBody;

        Mail::send('emails.echo', $data, function ($message) use ($email, $messageSubject) {
            $message->to($email);
            $message->subject($messageSubject);
        });
    }

    /**
    * Build email template
    * Return object (subject, body)
    */
    public static function buildMessage($hook, $parameters)
    {
        /**
        * ##SYSTEM_LOGO##
        * ##SYSTEM_APPLICATION_NAME##
        * ##EMAIL_CONTENT##
        * ##EMAIL_FOOTER##
        */
        $name       = '';
        if (isset($parameters->name)) :
            $name   = $parameters->name;
        endif;

        $email      = '';
        if (isset($parameters->email)) :
            $email  = $parameters->email;
        endif;

        $hookObject         = Hook::where('hook', '=', $hook)->first();
        $emailHook          = EmailHook::where('hook_id', '=', $hookObject->id)->first();
        $emailPreference    = $emailHook->emailpreference;

        /**
        * System Token
        */

        $systemLogo         = SettingHelper::logo();
        $systemAppName      = SettingHelper::application_title();
        $customMessage      = self::getCustomMessage($hook, $name, $email, $parameters);

        /**
        * Subject may contains ##USER_NAME##, ##USER_EMAIL## and ##SYSTEM_APPLICATION_NAME## hooks
        */

        $emailSubject       = str_ireplace('##USER_NAME##', $name, $emailHook->subject);
        $emailSubject       = str_ireplace('##USER_EMAIL##', $email, $emailSubject);
        $emailSubject       = str_ireplace('##SYSTEM_APPLICATION_NAME##', $systemAppName, $emailSubject);

        /**
        * Message may contains hooks like on the Subject and ##MESSAGE## hook
        */
        $emailBody          = str_ireplace('##USER_NAME##', $name, $emailHook->message);
        $emailBody          = str_ireplace('##USER_EMAIL##', $email, $emailBody);
        $emailBody          = str_ireplace('##SYSTEM_APPLICATION_NAME##', $systemAppName, $emailBody);
        $emailBody          = str_ireplace('##MESSAGE##', $customMessage, $emailBody);

        /**
        * Footer may contains hooks like on the Subject
        */
        $emailFooter        = str_ireplace('##USER_NAME##', $name, $emailHook->footer);
        $emailFooter        = str_ireplace('##USER_EMAIL##', $email, $emailFooter);
        $emailFooter        = str_ireplace('##SYSTEM_APPLICATION_NAME##', $systemAppName, $emailFooter);

        /**
        * Final email content
        */
        $emailContent       = $emailPreference->html;
        $emailContent       = str_ireplace('##SYSTEM_LOGO##', $systemLogo, $emailContent);
        $emailContent       = str_ireplace('##SYSTEM_APPLICATION_NAME##', $systemAppName, $emailContent);
        $emailContent       = str_ireplace('##EMAIL_FOOTER##', $emailFooter, $emailContent);
        $emailContent       = str_ireplace('##EMAIL_CONTENT##', $emailBody, $emailContent);

        $objEmail           = new \stdClass();
        $objEmail->subject  = $emailSubject;
        $objEmail->body     = $emailContent;

        return $objEmail;
    }

    private static function getCustomMessage($hook, $name, $email, $parameters)
    {
        $customMessage = '';

        if ($hook == 'user_register') :
            $customMessage = <<<HTML
<div id="mail_message_app">
  <p>Here are your login detail:</p>
  <p>
    <ul>
      <li>Name : {$name}</li>
      <li>Email : {$email}</li>
      <li>Password : {$parameters->password}</li>
    </ul>
  </p>
</div>
HTML;
        endif;

        if ($hook == 'admin_reset_user_password') :
            $customMessage = <<<HTML
<div id="mail_message_app">
  <p>We just received a request to update your password. Here is your new password:</p>
  <p>
    <ul>
      <li>Password : {$parameters->password}</li>
    </ul>
  </p>
</div>
HTML;
        endif;

        if ($hook == 'user_update_password') :
            $customMessage = <<<HTML
<div id="mail_message_app">
  <p>You just update your account, here are your updated account:</p>
  <p>
    <ul>
      <li>Name : {$name}</li>
      <li>Email : {$email}</li>
      <li>Password : {$parameters->password}</li>
    </ul>
  </p>
</div>
HTML;
        endif;

        return $customMessage;
    }
}
