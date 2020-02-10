<?php

namespace Modules\Core;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Appearance extends Model
{
    protected $guarded  = [];
    protected $table    = 'cwa_appearances';
    protected $fillable = ['override_main_header'];

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
