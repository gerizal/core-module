<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Modules\Core\UserLevel;
use Modules\Core\User;

class OnlyAdministrator
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
        $ul = UserLevel::find(1);

        $adminUserLevelId = 1;
        if (!is_null($ul)) {
            $adminUserLevelId = $ul->id;
        }

        $arrayUserlevelIds = json_decode(Auth::user()->userpreference->userlevel_id);

        // If user level id is not admin then return 404
        if (!in_array($adminUserLevelId, $arrayUserlevelIds)) {
            abort('404');
        }
        return $next($request);
    }
}
