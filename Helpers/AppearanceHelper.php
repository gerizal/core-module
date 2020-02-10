<?php

namespace Modules\Core\Helpers;

use Modules\Core\Appearance;

class AppearanceHelper
{
    public static function appearance()
    {
        return Appearance::find(1);
    }
}
