<?php

namespace Modules\Core;

use Illuminate\Database\Eloquent\Model;

use Vinkla\Hashids\Facades\Hashids;

class UserIntegration extends Model
{
    protected $guarded  = [];
    protected $table    = 'cwa_user_integrations';

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
}
