<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;
use Auth;
use Nwidart\Modules\Routing\Controller;

class UserIntegrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $userintegration    = Auth::user()->userintegration;
        $protocol           = 'http';

        if (isset($_SERVER['REQUEST_SCHEME'])) {
            $protocol       = $_SERVER['REQUEST_SCHEME'];
        }

        $url        = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $uNode      = 'autoresponders';

        if (stripos($url, '?twilio') !== false) {
            $uNode  = 'twilio';
        }

        if (stripos($url, '?google') !== false) {
            $uNode  = 'google';
        }

        return view('core::core.integration.index', compact('uNode', 'userintegration'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $integration)
    {
        $this->validate($request, [
            'aweber_code'                   => 'max:255',
            'getresponse_api_key'           => 'max:50',
            'mailchimp_api_key'             => 'max:50',
            'activecampaign_api_url'        => 'url|max:50',
            'activecampaign_api_key'        => 'max:150',
            'madmimi_email'                 => 'max:50',
            'madmimi_api_key'               => 'max:50',
            'constantcontact_api_key'       => 'max:50',
            'constantcontact_access_token'  => 'max:50',
            'icontact_app_id'               => 'max:50',
            'icontact_api_password'         => 'max:50',
            'icontact_api_username'         => 'max:50',
            'twilio_account_sid'            => 'max:50',
            'twilio_auth_token'             => 'max:50',
            'twilio_number'                 => 'max:50',
            'google_client_id'              => 'max:150',
            'google_client_secret'          => 'max:50'
        ]);

        $rRequest = $request->integration_node;

        if ($rRequest == 'autoresponders') :
            $integration->aweber_code                   = $request->aweber_code;
            $integration->getresponse_api_key           = $request->getresponse_api_key;
            $integration->mailchimp_api_key             = $request->mailchimp_api_key;
            $integration->activecampaign_api_url        = $request->activecampaign_api_url;
            $integration->activecampaign_api_key        = $request->activecampaign_api_key;
            $integration->madmimi_email                 = $request->madmimi_email;
            $integration->madmimi_api_key               = $request->madmimi_api_key;
            $integration->constantcontact_api_key       = $request->constantcontact_api_key;
            $integration->constantcontact_access_token  = $request->constantcontact_access_token;
            $integration->icontact_app_id               = $request->icontact_app_id;
            $integration->icontact_api_password         = $request->icontact_api_password;
            $integration->icontact_api_username         = $request->icontact_api_username;
            $integration->update();
        endif;

        if ($rRequest == 'twilio') :
            $integration->twilio_account_sid            = $request->twilio_account_sid;
            $integration->twilio_auth_token             = $request->twilio_auth_token;
            $integration->twilio_number                 = $request->twilio_number;
            $integration->update();
        endif;

        if ($rRequest == 'google') :
            $integration->google_client_id              = $request->google_client_id;
            $integration->google_client_secret          = $request->google_client_secret;
            $integration->update();
        endif;

        $redir      = 'integration';

        if ($rRequest != 'autoresponders') {
            $redir  = 'integration?' . $rRequest;
        }

        return redirect($redir)->with('message', 'Your '.$rRequest.' integration was updated.');
    }
}
