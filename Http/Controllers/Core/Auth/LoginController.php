<?php

namespace Modules\Core\Http\Controllers\Core\Auth;

use Nwidart\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Modules\Core\User;
use Modules\Core\UserLevel;
use Modules\Core\Helpers\SettingHelper;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (view()->exists('cwaextends.login')) {
            return view('cwaextends.login');
        }
        
        return view('core::core.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        // Login with credentials
        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        /**
         * Login using hash password for specific application
         */
        $getUserFromEmail = User::where('email', $credentials['email'])->first();
        
        if (!is_null($getUserFromEmail)) {
            if ($credentials['password'] === $getUserFromEmail->password) {
                Auth::loginUsingId($getUserFromEmail->id);
                
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $isUserExpired              = Auth::user()->checkUserExpiration();
        $redirectWhenExpired        = SettingHelper::redirect_when_expired();
        
        if (empty($redirectWhenExpired)) {
            // Redirect to expired route by default
            $redirectWhenExpired    = 'expired';
        }

        // If value is an empty array
        // If value is true
        if ((is_bool($isUserExpired) && $isUserExpired == true) || (is_array($isUserExpired) && count($isUserExpired) < 1)) {
            Auth::logout();

            return redirect($redirectWhenExpired)->with('user', Auth::user());
        }

        if (is_array($isUserExpired) && count($isUserExpired) > 0) {
            $expireds       = [];
            foreach ($isUserExpired as $uE) {
                $expireds[] = $uE['expired'];
            }

            $isExpired      = in_array(true, $expireds);
            
            if ($isExpired) {
                Auth::logout();

                return redirect($redirectWhenExpired)->with('user', Auth::user());
            }
        }

        // Check user preference, if user is deactivated then return an error message
        // and redirect to login
        if (!$this->isUserActive()) {
            Auth::logout();
            return redirect('auth/login')->with('message', 'Your account is inactive.');
        }

        $up                 = Auth::user()->userpreference;
        $up->last_logged_in = date('Y-m-d H:i:s');
        $up->update();

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        # Get user levels
        $userLevels         = [];
        if (isset(Auth::user()->userpreference->userlevel_id)) {
            $jsonUserLevels = Auth::user()->userpreference->userlevel_id;

            if (!empty($jsonUserLevels)) {
                $userLevels = json_decode($jsonUserLevels);
            }
        }

        sort($userLevels);

        $lowestUserLevel    = 0;

        if (!empty($userLevels)) {
            if (count($userLevels) > 0) {
                $lowestUserLevel = (int)$userLevels[0];
            }
        }

        if ($lowestUserLevel) {
            # Redirect based on user level
            $userLevel      = UserLevel::find($lowestUserLevel);
            if (!is_null($userLevel)) {
                # If there's no redirect configured, then redirect to /home
                if (empty($userLevel->redirect)) {
                    return redirect('home');
                }

                return redirect($userLevel->redirect);
            }
        } else {
            # By default, redirect to /home
            return redirect('home');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        $logoutRedirect     = 'auth/login';
        if (!empty(SettingHelper::logout_redirect())) {
            $logoutRedirect = SettingHelper::logout_redirect();
        }
        
        return redirect($logoutRedirect);
    }

    /**
     * Check if user active
     */
    private function isUserActive()
    {
        $isUserActive = Auth::user()->userpreference->is_user_active;

        if ($isUserActive == 'YES') {
            return true;
        }

        return false;
    }
}
