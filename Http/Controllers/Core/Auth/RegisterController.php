<?php

namespace Modules\Core\Http\Controllers\Core\Auth;

use App\User;
use Validator;
use Nwidart\Modules\Routing\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

use Modules\Core\Helpers\SettingHelper;
use Modules\Core\Helpers\UserHelper;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('guest');
    }

    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        if (SettingHelper::allow_public_signup() == 'NO') {
            return redirect('auth/login');
        }
        
        return view('core::core.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255|unique:cwa_users',
            'password'  => 'required|min:6|confirmed',
            'terms'     => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
        ]);

        // See UserHelper.php in app/Helpers
        $request                = new \stdClass();
        $request->userlevel_id  = ["2"];
        $request->affiliate_id  = 0;
        $request->name          = $data['name'];
        $request->email         = $data['email'];
        $request->password      = $data['password'];

        UserHelper::after_register($user, $request);

        return $user;
    }
}
