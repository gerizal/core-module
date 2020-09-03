<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;

use Auth;
use Config;
use Modules\Core\User;
use Modules\Core\UserPreference;
use Modules\Core\UserLevel;
use Modules\Core\UserEmailTrack;
use Modules\Core\UserSubscription;
use Modules\Core\Helpers\MailHelper;

use Nwidart\Modules\Routing\Controller;

class ProfileController extends Controller
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
        $profile            = Auth::user();
        // januar's here
        // $avatarOriginal     = url(str_replace('App/User', 'Modules/Core/User', $profile->avatar->url()));
        // $avatarMedium       = url(str_replace('App/User', 'Modules/Core/User', $profile->avatar->url('medium')));
        // $avatarThumbnail    = url(str_replace('App/User', 'Modules/Core/User', $profile->avatar->url('thumb')));
        $avatarOriginal     = env('AZURE_EDGE').env('AZURE_STORAGE_CONTAINER_IMAGE_BUCKET').'/avatars/' . $profile->id . '/original/'. $profile->avatar_file_name;
        $avatarMedium       = $avatarOriginal;
        $avatarThumbnail       = $avatarOriginal;
        $userLevelIds       = json_decode($profile->userpreference->userlevel_id);
        $updateAvatarUrl    = url('profile/'.$profile->uniqueid().'/update_avatar');

        $ulName = '';
        if (!empty($userLevelIds)) {
            foreach ($userLevelIds as $ulId) {
                $ulObj = UserLevel::where('id', '=', $ulId)->first();
                $ulName .= '<span class="label label-warning">'.$ulObj->name.'</span>&nbsp;';
            }
        }

        $protocol = 'http';
        if (isset($_SERVER['REQUEST_SCHEME'])) {
            $protocol = $_SERVER['REQUEST_SCHEME'];
        }

        $url = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

        $uNode = 'profile';
        if (stripos($url, '?subscription') !== false) {
            $uNode = 'subscription';
        }

        if (stripos($url, '?advance') !== false) {
            $uNode = 'advance';
        }

        $userSubscription = $profile->usersubscription;

        return view(
            'core::core.profile.profile',
            compact(
                'profile',
                'ulName',
                'uNode',
                'avatarOriginal',
                'avatarMedium',
                'avatarThumbnail',
                'userSubscription',
                'updateAvatarUrl'
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
    public function update(Request $request, $user)
    {
        $updateResultPortal     = '';
        $emailBeforeUpdate      = $user->email;

        if ($request->_node == 'profile') :
            $validationParam    = '';
            $rEmail             = $request->email;

            if ($rEmail != $user->email) :
                $validationParam = '|unique:cwa_users';
            endif;

            $this->validate($request, [
                'name'      => 'required|max:255',
                'email'     => 'email|required|max:255' . $validationParam,
                'password'  => 'min:5|max:16',
                'avatar'    => 'image'
            ]);

            // If user use different email, then store old email to the user_email_tracks table
            $emails = $this->getUserEmails($user);

            $isEmailInTracks = array_search($user->email, $emails);

            if ($rEmail != $user->email) :
                if ($isEmailInTracks == false) :
                    $this->trackEmail($user);
                endif;
            endif;

            // Update user table
            $this->updateUserProfile($request, $user);

            // Update password if password is not empty
            $rPassword = $request->password;
            if (!empty($rPassword)) {
                $user->password = bcrypt($rPassword);
                $user->update();

                // Send email to user if the password was updated
                $this->sendEmailPasswordUpdated($request, $rPassword);
            }

            // Change password and username in Product Portal from this update
            $result = $this->updateInProductPortal($request, $emailBeforeUpdate);
            $updateResultPortal = $result;
        endif;

        if ($request->_node == 'subscription') :
            $this->updateUserSubscription($user, $request);
        endif;

        $redir = 'profile';
        if ($request->_node == 'subscription') :
            $redir = 'profile?subscription';
        endif;

        // Return message updated with notification if the username and password in product portal is changed as well
        if ($updateResultPortal == null) {
            return redirect($redir)->with('message', 'Your '.$request->_node.' was updated.');
        }

        return redirect($redir)->with(
            'message',
            sprintf(
                'Your %s was updated, and your %s password and username in Product Portal was updated as well.',
                $request->_node,
                $updateResultPortal
            )
        );
    }

    public function deleteMyAccount(User $user)
    {
        if (isset($_SERVER)) :
            if (empty($_SERVER['HTTP_REFERER'])) :
                abort(404);
            endif;
        endif;

        $profile = $user;
        return view('core::core.profile.delete_my_account', compact('profile'));
    }

    public function confirmDeleteMyAccount(Request $request, User $user)
    {
        $this->validate($request, [
            'password' => 'required|min:5|max:16'
        ]);

        if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            // Perform account deletion

            // Deactivate the user
            $up = UserPreference::where('user_id', '=', $user->id)->first();
            $up->is_user_active = 'NO';
            $up->update();

            // Perform more to do

            // Logout authenticated user and then redirect to login page with custom message
            Auth::logout();
            return redirect('/auth/login')
                ->with(
                    'msgAccountDeletion',
                    'Your account '.$user->email.' has been deleted. You will not be able to login again.'
                );
        }

        return redirect('/profile/'.$user->uniqueid().'/delete_my_account')
            ->with('errorPassConf', 'Your password does not match with your account.');
    }

    public function updateAvatar(Request $request, User $user)
    {
        // $user->avatar = $request->avatar;
        // \Log::info($request->avatar);
        // $filename = $request->avatar;
        // $user->avatar_file_name = $filename;
        // $user->avatar_file_size = File::size($request->file('avatar'));
        // $user->avatar_content_type = File::mimeType($request->file('avatar'));
        // $user->avatar_updated_at = \Carbon\Carbon::now('UTC');

        // // upload
        // $azure = Storage::disk('azureImageBucket');
        // $filepath = 'avatars/original/'. $user->id . '/original/' . $filename;
        // $azure->put($filepath, file_get_contents($file), 'public');
        $user->update();
        return 'AVATAR_UPDATED';
    }

    private function trackEmail($user)
    {
        $useremailtrack             = new UserEmailTrack;
        $useremailtrack->user_id    = $user->id;
        $useremailtrack->email      = $user->email;
        $useremailtrack->save();
    }

    private function sendEmailPasswordUpdated($request, $rPassword)
    {
        $userObject             = new \stdClass();
        $userObject->name       = $request->name;
        $userObject->email      = $request->email;
        $userObject->password   = $rPassword;

        MailHelper::send('user_update_password', $userObject);
    }

    private function updateUserSubscription($user, $request)
    {
        $us                 = UserSubscription::where('user_id', '=', $user->id)->first();
        $us->news           = $request->news;
        $us->notifications  = $request->notifications;
        $us->update();
    }

    private function updateUserProfile($request, $user)
    {
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->avatar       = $request->avatar;
        $user->update();
    }

    private function getUserEmails($user)
    {
        $emails = [];
        if ($user->emails->count() > 0) {
            foreach ($user->emails as $uemail) {
                $emails[] = $uemail->email;
            }
        }

        return $emails;
    }

    private function updateInProductPortal($request, $oldEmail)
    {
        $rPassword  = $request->password;
        $config     = config('app.product_portal');

        if ($config == null) {
            return $config['name'];
        }

        $ch     = curl_init();
        $post   = [
            'oldEmail'  => $oldEmail,
            'email'     => $request->email,
            'password'  => $rPassword,
            'product'   => $config['name'],
        ];

        curl_setopt($ch, CURLOPT_URL, $config['url'] . '/change_email_password_to_productportal');
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $server_output  = curl_exec($ch);
        curl_close($ch);

        $output         = json_decode($server_output);

        if ($output != null && $output->status == 'OK') {
            return $config['name'];
        }
    }
}
