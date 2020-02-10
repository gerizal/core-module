<?php

namespace Modules\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPreference extends Model
{
    use SoftDeletes;

    protected $guarded  = [];
    protected $table    = 'cwa_user_preferences';

    public function userlevel()
    {
        return $this->belongsTo('Modules\Core\UserLevel');
    }
}
