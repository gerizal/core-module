<?php

namespace Modules\Core;

use Illuminate\Database\Eloquent\Model;

class UserEmailTrack extends Model
{
    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates    = ['deleted_at'];
    protected $guarded  = [];
    protected $table    = 'cwa_user_email_tracks';
}
