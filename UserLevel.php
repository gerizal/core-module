<?php

namespace Modules\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Vinkla\Hashids\Facades\Hashids;

class UserLevel extends Model
{
    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates    = ['deleted_at'];
    protected $guarded  = [];
    protected $table    = 'cwa_user_levels';

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

    /**
    * get list of user's feature access
    * @param string $tag
    * @return string|null
    */
    public function getFeatureAccess($tag)
    {
        $features   = json_decode($this->features, true);
        if (isset($features[$tag])) {
            return $features[$tag] === true ? " " : $features[$tag];
        }

        return null;
    }
}
