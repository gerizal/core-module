<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Modules\Core\Helpers\SettingHelper;

class AutoLogoutExpiredAccount
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        $isUserExpired          = Auth::user()->checkUserExpiration();
        $redirectWhenExpired    = SettingHelper::redirect_when_expired();

        if (empty($redirectWhenExpired)) {
            // Redirect to expired route by default
            $redirectWhenExpired = 'expired';
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

        return $next($request);
    }
}
