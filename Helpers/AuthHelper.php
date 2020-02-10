<?php

namespace Modules\Core\Helpers;

use Auth;
use Modules\Core\User;

class AuthHelper
{
    private static function getUserLevelTracks($userId)
    {
        $user       = User::find($userId);
        if ($user->count() <1) {
            return [];
        }

        $userLevels = json_decode($user->userpreference->userlevel_id, true);
        
        $_u         = [];
        foreach ($user->userleveltracks as $ut) {
            if (in_array($ut->userlevel_id, $userLevels)) {
                $_u[] = $ut;
            }
        }

        return $_u;
    }

    public static function checkUserExpiration($userLevelId = '', $userId)
    {
        $_tracks    = self::getUserLevelTracks($userId);
        $_results   = [];

        if (!empty($_tracks)) {
            foreach ($_tracks as $_track) {
                $timeLimit      = $_track->userlevel->time_limit;

                $currentDate    = new \DateTime(date('Y-m-d H:i:s'));
                $startDate      = new \DateTime($_track->start_date);
                $interval       = (int)$currentDate->diff($startDate)->format('%a');

                $_expired       = false;
                if ($interval > $timeLimit) {
                    $_expired   = true;
                }

                if ($timeLimit == 0) {
                    $_expired   = false;
                }

                $_remaining     = 0;
                if ($timeLimit >= $interval) {
                    $_remaining = $timeLimit - $interval;
                }

                $_results[$_track->userlevel->id] = [
                    'userlevel_id'      => $_track->userlevel->id,
                    'userlevel_name'    => $_track->userlevel->name,
                    'start_date'        => $startDate,
                    'limit'             => $timeLimit,
                    'expired'           => $_expired,
                    'remaining'         => $_remaining
                ];
            }
        }

        if (!empty($userLevelId)) {
            if (isset($_results[$userLevelId])) {
                return $_results[$userLevelId]['expired'];
            }
        }

        return $_results;
    }
}