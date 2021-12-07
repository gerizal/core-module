<?php

namespace Modules\Core;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Vinkla\Hashids\Facades\Hashids;
// use Codesleeve\Stapler\ORM\StaplerableInterface;
// use Codesleeve\Stapler\ORM\EloquentTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table    = 'cwa_users';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name', 'email', 'password', 'avatar', 'features'];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden   = ['password', 'remember_token'];

    public function __construct(array $attributes = array())
    {

        parent::__construct($attributes);
    }

    public function uniqueid()
    {
        $uniqueId   = Hashids::encode($this->id);
        return $uniqueId;
    }

    public static function originalid($value)
    {
        $originalId = Hashids::decode($value)[0];
        return $originalId;
    }

    public function userpreference()
    {
        return $this->hasOne('Modules\Core\UserPreference');
    }

    public function usersubscription()
    {
        return $this->hasOne('Modules\Core\UserSubscription');
    }

    public function userintegration()
    {
        return $this->hasOne('Modules\Core\UserIntegration');
    }

    public function emails()
    {
        return $this->hasMany('Modules\Core\UserEmailTrack');
    }

    public function dismissednotifications()
    {
        return $this->hasMany('Modules\Notification\NotificationTrack')
            ->where('status', '=', 'DISMISSED')
            ->select(array('notification_id'));
    }

    /**
    * Check is logged user has access to something
    * @param string $tag Feature tag name
    * @return boolean|null true: has access, false: doesn't has access, null: tag name is invalid
    */
    public function hasAccess($tag)
    {
        $features       = [];
        $userPreference = $this->userpreference;
        $userLevels     = json_decode($userPreference->userlevel_id, true);
        foreach ($userLevels as $userlevelId) {
            $userLevel  = UserLevel::find($userlevelId);
            $fs         = json_decode($userLevel->features, true);

            if ($fs != null) {
                foreach ($fs as $f => $v) {
                    $features[$f] = $v;
                }
            }
        }

        if (isset($features[$tag])) {
            return $features[$tag] === true ? true : $features[$tag];
        }

        return false;
    }

    public function userleveltracks()
    {
        return $this->hasMany('Modules\Core\UserLevelTrack');
    }

    public function checkUserExpiration()
    {
        return \Modules\Core\Helpers\AuthHelper::checkUserExpiration('', $this->id);
    }
}
