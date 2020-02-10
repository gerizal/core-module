<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;

use DB;
use Modules\Core\User;
use Modules\Core\UserLevel;
use Modules\Core\UserPreference;
use Modules\Core\UserLevelTrack;

use Auth;
use Nwidart\Modules\Routing\Controller;

use Modules\Core\Helpers\MailHelper;
use Modules\Core\Helpers\UserHelper;
use Hashids;

class UserController extends Controller
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
        return view('core::core.user.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        $userlevels         = UserLevel::all();
        $lastrecentusers    = User::orderBy('updated_at', '=', 'DESC')->take(3)->get();
        $customFields       = UserHelper::getUserCustomFields();

        return view('core::core.user.create', compact('userlevels', 'lastrecentusers', 'customFields'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:255',
            'email'         => 'email|required|max:255|unique:cwa_users',
            'password'      => 'required|min:5|max:16',
            'userlevel_id'  => 'required'
        ]);

        // Save to user table
        $user           = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->custom_field_values = json_encode($request->custom_fields);
        $user->save();

        UserHelper::after_register($user, $request);

        $redir      = 'user';
        if ($request->destination == 'create') {
            $redir  = 'user/' . $request->destination;
        }

        \CwaHooks::action('cwa.hook.action.after_create_user', $user);

        return redirect($redir)
            ->with(
                'message',
                'User <a href="'.url('user', $user->uniqueid()).'">'.$user->name.' ('.$user->email.')</a> was created.'
            );
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show(User $user)
    {
        return view('core::core.user.show', compact('user'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit(User $user)
    {
        $userlevels     = UserLevel::all();
        $customFields   = UserHelper::getUserCustomFields();

        return view('core::core.user.edit', compact('userlevels', 'user', 'customFields'));
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
        $oldEmail               = $user->email;
        $validationParam        = '';
        $rEmail                 = $request->email;
        $rPassword              = $request->password;

        if ($rEmail != $user->email) :
            $validationParam    = '|unique:cwa_users';
        endif;

        $this->validate($request, [
            'name'              => 'required|max:255',
            'email'             => 'email|required|max:255'.$validationParam,
            'password'          => 'min:5|max:16',
            'userlevel_id'      => 'required'
        ]);

        // Update user table
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->custom_field_values = json_encode($request->custom_fields);
        $user->update();

        // Update password if password is not empty
        if (!empty($rPassword)) {
            $user->password     = bcrypt($request->password);
            $user->update();
        }

        $up                     = UserPreference::where('user_id', $user->id)->first();
        $uLExisting             = json_decode($up->userlevel_id, true);

        // Update user level tracks
        if ($uLExisting !== $request->userlevel_id) {
            // First, delete all existing user level tracks belong to user
            UserLevelTrack::where('user_id', $user->id)->delete();
            if (!empty($request->userlevel_id)) {
                foreach ($request->userlevel_id as $ulevel) {
                    // Add new user level to user level tracks with new start date
                    $ult                = new UserLevelTrack();
                    $ult->user_id       = $user->id;
                    $ult->userlevel_id  = $ulevel;
                    $ult->start_date    = date('Y-m-d H:i:s');
                    $ult->save();
                }
            }
        }

        // If the reset start date checked, the existing start date for selected user level will be updated
        if (isset($request->reset_start_date)) {
            if ($request->userlevel_id == $uLExisting) {
                if (!empty($request->userlevel_id)) {
                    foreach ($request->userlevel_id as $ulevel) {
                        UserLevelTrack::where('userlevel_id', $ulevel)
                            ->where('user_id', $user->id)
                            ->update(['start_date' => date('Y-m-d H:i:s')]);
                    }
                }
            }
        }

        // Update user preference
        $up                     = UserPreference::where('user_id', '=', $user->id)->first();
        $up->userlevel_id       = json_encode($request->userlevel_id);
        $up->affiliate_id       = $request->affiliate_id;
        $up->update();

        $newEmail               = $request->email;
        $newPassword            = $request->password;

        //vinsen
        if (false) {
            $this->changeUserPasswordInOtherPlaces($user, $oldEmail, $newEmail, $newPassword);
        }

        return redirect()->route('user.edit', $user->uniqueid())
            ->with(
                'message',
                'User <a href="'.url('user', $user->uniqueid()).'">'.$user->name.' ('.$user->email.')</a> was updated.'
            );
    }

    public function changeUserPasswordInOtherPlaces($user, $oldEmail, $newEmail, $newPassword)
    {
        $userId         = $user->id;
        $userProducts   = DB::table('user_products')
            ->where('user_id', '=', $userId)
            ->get();

        for ($i = 0; $i < count($userProducts); $i++) {
            $productId      = $userProducts[$i]->product_id;
            $userProduct    = DB::table('user_products')
                ->where('user_id', '=', $userId)
                ->where('product_id', '=', $productId)
                ->update(['username' => $newEmail]);

            if (!empty($newPassword)) {
                $userProduct = DB::table('user_products')
                    ->where('user_id', '=', $userId)
                    ->where('product_id', '=', $productId)
                    ->update(['password' => $newPassword]);
            }

            $productlogin   = DB::table('product_logins')
                ->where('id', '=', $productId)
                ->get();

            $productlogin   = $productlogin[0];

            $ch     = curl_init();
            $post   = [
                'currentEmail'  => $oldEmail,
                'newEmail'      => $newEmail,
                'newPassword'   => $newPassword,
            ];

            curl_setopt($ch, CURLOPT_URL, $productlogin->URL . '/api/change_email_password_core_module');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);

            curl_exec($ch);
            curl_close($ch);
        }
    }


    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy(User $user)
    {
        $up                 = UserPreference::where('user_id', '=', $user->id)->first();
        $up->is_user_active = 'NO';
        $up->update();

        return 'DEACTIVATED';
    }

    /**
    * Toogle Activate User
    *
    * @param  Resource  $user
    * @return String
    */
    public function toggleActivate(Request $request)
    {
        $id             = Hashids::decode($request->uid)[0];
        $up             = UserPreference::where('user_id', '=', $id)->first();

        $_isUserActive  = 'YES';
        $status         = 'ACTIVATED';

        if ($up->is_user_active == 'YES') {
            $_isUserActive  = 'NO';
            $status         = 'DEACTIVATED';
        }

        $up->is_user_active = $_isUserActive;
        $up->update();

        return $status;
    }

    /**
    * Reset user password
    */
    public function adminResetUserPassword(User $user)
    {
        $newPassword    = str_random(8);

        // Update user password
        $user->password = bcrypt($newPassword);
        $user->update();

        $userObject             = new \stdClass();
        $userObject->name       = $user->name;
        $userObject->email      = $user->email;
        $userObject->password   = $newPassword;

        MailHelper::send('admin_reset_user_password', $userObject);

        return [
            'resCode' => 'success',
            'resMessage' => $newPassword
        ];
    }

    /**
    * Trash user
    */
    public function adminTrashUser(User $user)
    {
        // Disable trash user if user is admin
        if ($user->id == 1) {
            return [
                'resCode'       => 'error',
                'resMessage'    => 'Unable to trash Administrator user.'
            ];
        }

        $user->delete();

        return [
            'resCode'       => 'success',
            'resMessage'    => 'User '.$user->email.' has been trashed.'
        ];
    }

    public function display(Request $request)
    {
        $orderBy    = 'cwa_users.name';
        $orderSort  = 'asc';

        if ($request->order[0]['dir'] == 'desc') {
            $orderSort = 'desc';
        }

        if ($request->order[0]['column'] == 0) {
            $orderBy = 'cwa_users.name';
        }

        if ($request->order[0]['column'] == 1) {
            $orderBy = 'cwa_users.email';
        }

        $users      = User::where('cwa_users.name', 'like', '%' . $request->search['value'] . '%')
                ->orWhere('cwa_users.email', 'like', '%' . $request->search['value'] . '%')
                ->skip($request->start)->take($request->length)
                ->orderBy($orderBy, $orderSort)
                ->get();

        $countUser  = User::where('cwa_users.name', 'like', '%' . $request->search['value'] . '%')
                ->orWhere('cwa_users.email', 'like', '%' . $request->search['value'] . '%')
                ->orderBy($orderBy, $orderSort)
                ->get()->count();

        if (!empty($users)) {
            $newUsers               = [];
            foreach ($users as $user) {
                $userPreference     = $user->userpreference;
                $up                 = $this->getUserPreference($userPreference);
                $lastLoggedIn       = $up['lastLoggedIn'];
                $userStatus         = $up['userStatus'];
                $actions            = $this->getActionsButton($user, $userPreference);
                $userLevelIds       = [];

                if (!empty($userPreference)) {
                    $userLevelIds   = json_decode($userPreference->userlevel_id);
                }

                $ulName             = '';

                if (!empty($userLevelIds)) {
                    foreach ($userLevelIds as $ulId) {
                        $ulObj      = UserLevel::where('id', '=', $ulId)->first();
                        if (!empty($ulObj)) {
                            $ulName .= '<p><span class="label label-warning">'.$ulObj->name.'</span></p>';
                        }
                    }
                }

                $userEmails         = '<p><span class="label label-success">'.$user->email.'</span></p>';

                if ($user->emails->count() > 0) {
                    foreach ($user->emails as $uemail) {
                        if ($uemail->email !== $user->email) {
                            $userEmails .= '<p><span class="label label-success">'.$uemail->email.'</span></p>';
                        }
                    }
                }

                $objUsers   = [];
                $objUsers[] = $user->name;
                $objUsers[] = $userEmails;
                $objUsers[] = $ulName;
                $objUsers[] = $userStatus;
                $objUsers[] = $lastLoggedIn;
                $objUsers[] = $actions;
                $newUsers[] = $objUsers;
            }
        }

        return [
            'iTotalRecords'         => $countUser,
            'iTotalDisplayRecords'  => $countUser,
            'data'                  => $newUsers
        ];
    }

    private function getActionsButton($user, $userPreference)
    {
        if ($userPreference != null) {
            $toggleActivate     = route('user.activate', $user->uniqueid());
            $resetPasswordLink  = url('/user/'.$user->uniqueid().'/admin_reset_user_password');
            $trashLink          = url('/user/'.$user->uniqueid().'/admin_trash_user');

            $actions            = sprintf(
                '<a href="%s" class="btn btn-xs btn-primary" data-toggle="tooltip"
                    title="Edit user %s">
                    <i class="fa fa-pencil-square-o"></i>
                </a>&nbsp;',
                route('user.edit', $user->uniqueid()),
                $user->email
            );

            $_toggleActivate    = sprintf(
                '<button type="button" data-targetlink="%s" data-email="%s"
                    class="btn btn-xs btn-warning %s"
                    data-toggle="tooltip"
                    title="Activate user %s" data-uid="%s">
                    <i class="fa fa-toggle-off"></i>
                </button>&nbsp;',
                $toggleActivate,
                $user->email,
                'admin_activate',
                $user->email,
                $user->uniqueid()
            );

            if ($userPreference->is_user_active == 'YES') {
                $_toggleActivate = sprintf(
                    '<button type="button" data-targetlink="%s" data-email="%s"
                        class="btn btn-xs btn-success %s"
                        data-toggle="tooltip"
                        title="Deactivate user %s"
                        data-uid="%s">
                        <i class="fa fa-toggle-on"></i>
                    </button>&nbsp;',
                    $toggleActivate,
                    $user->email,
                    'admin_deactivate',
                    $user->email,
                    $user->uniqueid()
                );
            }

            $actions .= $_toggleActivate;

            $actions .= sprintf(
                '<button type="button" data-resetpasswordlink="%s" data-user="%s" data-email="%s"
                    class="btn btn-xs btn-danger %s"
                    data-toggle="tooltip"
                    title="Reset user %s password">
                    <i class="fa fa-key"></i>
                </button>&nbsp;',
                $resetPasswordLink,
                $user->uniqueid(),
                $user->email,
                'admin_resetpassword',
                $user->email
            );

            $actions .= sprintf(
                '<button type="button" data-trashlink="%s" data-user="%s" data-email="%s"
                    class="btn btn-xs btn-danger %s"
                    data-toggle="tooltip"
                    title="Trash user %s">
                    <i class="fa fa-trash"></i>
                </button>',
                $trashLink,
                $user->uniqueid(),
                $user->email,
                'admin_trashuser',
                $user->email
            );

            return $actions;
        }
    }

    private function getUserPreference($userPreference)
    {
        $lastLoggedIn   = 'Unknown';
        $userStatus     = '<span class="label label-success">YES</span>';

        if (!is_null($userPreference)) {
            $strLastLoggedIn    = $userPreference->last_logged_in;
            $lastLoggedIn       = 'Unknown';

            if ($strLastLoggedIn != '1970-01-01 00:00:00') {
                $lastLoggedIn   = date('M j, Y g:ia', strtotime($strLastLoggedIn));
            }

            $userStatus         = '<span class="label label-info">Unknown</span>';
            if (!empty($userPreference->is_user_active)) {
                $userStatus     = sprintf(
                    '<span class="label label-danger">%s</span>',
                    $userPreference->is_user_active
                );

                if ($userPreference->is_user_active == 'YES') {
                    $userStatus = sprintf(
                        '<span class="label label-success">%s</span>',
                        $userPreference->is_user_active
                    );
                }
            }
        }

        return [
            'lastLoggedIn'  => $lastLoggedIn,
            'userStatus'    => $userStatus
        ];
    }
}
