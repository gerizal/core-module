<?php

namespace Modules\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLevelTrack extends Model
{
    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates    = ['deleted_at'];
    protected $guarded  = [];
    protected $table    = 'cwa_user_level_tracks';

    public function userlevel()
    {
        return $this->belongsTo('Modules\Core\UserLevel');
    }
}
