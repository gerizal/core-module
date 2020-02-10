<?php
namespace Modules\Core\Helpers;

use Modules\Core\UserPreference;
use Modules\Core\UserIntegration;
use Modules\Core\UserSubscription;
use Modules\Core\UserLevelTrack;

use Modules\Core\Helpers\SettingHelper;
use Modules\Core\Helpers\MailHelper;
use Auth;
use Modules\JVZoo\JVZoo;

class UserHelper
{
    public static function updateUserLevelTrack($user, $userLevels)
    {
        if (!empty($userLevels)) {
            foreach ($userLevels as $userLevel) {
                $levelTrack = UserLevelTrack::where('userlevel_id', (int)$userLevel)->where('user_id', $user->id)->first();
                if (is_null($levelTrack)) {
                    $ult                = new UserLevelTrack;
                    $ult->user_id       = $user->id;
                    $ult->userlevel_id  = (int)$userLevel;
                    $ult->start_date    = date('Y-m-d H:i:s');
                    $ult->save();
                }
            }
        }
    }

    public static function after_register($user, $request)
    {
        // Save to user level tracks table
        self::updateUserLevelTrack($user, $request->userlevel_id);

        // Save to user preference table
        $up                 = new UserPreference;
        $up->user_id        = $user->id;
        $up->is_user_active = 'YES';
        $up->display_notice = 'YES';
        $up->last_logged_in = '1970-01-01 00:00:00';
        $up->upsell_id      = 0;
        $up->userlevel_id   = json_encode($request->userlevel_id);
        $up->api_key        = str_random(3) . '-' . str_random(40);
        $up->affiliate_id   = $request->affiliate_id;
        $up->save();

        // Save to user integration table
        $ui                                 = new UserIntegration;
        $ui->user_id                        = $user->id;
        $ui->aweber_code                    = '';
        $ui->getresponse_api_key            = '';
        $ui->mailchimp_api_key              = '';
        $ui->activecampaign_api_url         = '';
        $ui->activecampaign_api_key         = '';
        $ui->madmimi_email                  = '';
        $ui->madmimi_api_key                = '';
        $ui->constantcontact_api_key        = '';
        $ui->constantcontact_access_token   = '';
        $ui->icontact_app_id                = '';
        $ui->icontact_api_password          = '';
        $ui->icontact_api_username          = '';
        $ui->twilio_account_sid             = '';
        $ui->twilio_auth_token              = '';
        $ui->twilio_number                  = '';
        $ui->google_client_id               = '';
        $ui->google_client_secret           = '';
        $ui->custom_integrations            = '';
        $ui->save();

        $us                 = new UserSubscription;
        $us->user_id        = $user->id;
        $us->news           = 'YES';
        $us->notifications  = 'YES';
        $us->save();

        if (class_exists('Modules\\Hook\\Hook')) {
            // Send Email
            MailHelper::send('user_register', $request);
        }
    }

    public static function jvzootransactions()
    {
        return JVZoo::where('ccustemail', '=', Auth::user()->email)
            ->orWhereIn('ccustemail', self::emailsToArray())
            ->get();
    }

    public static function emailsToArray()
    {
        $emailArray     = array();
        $emailtracks    = Auth::user()->emails;

        if ($emailtracks->count() > 0) {
            foreach ($emailtracks as $et) {
                $emailArray[] = $et->email;
            }
        }

        return $emailArray;
    }

    public static function getUserCustomFields()
    {
        $getUserCustomFields    = SettingHelper::user_custom_fields();
        $customFields           = [];
        if (!empty($getUserCustomFields)) {
            $userCustomFields   = explode("\n", str_replace("\r", "" ,$getUserCustomFields));
            if (!empty($userCustomFields)) {
                foreach ($userCustomFields as $cField) {
                    $field = explode("|", $cField);

                    $aFields = [];
                    if (!empty($field)) {
                        $cName = $field[0];
                        $cFieldName = $field[1];

                        $aFields['name'] = $cName;
                        $aFields['field'] = $cFieldName;
                    }
                    $customFields[] = $aFields;
                }
            }
        }

        return $customFields;
    }

    public static function getValueCustomField($user, $field)
    {
        $customFieldValues = json_decode($user->custom_field_values);

        $cValue = '';
        if (isset($customFieldValues->$field)) {
            $cValue = $customFieldValues->$field;
        }

        return $cValue;
    }
}
