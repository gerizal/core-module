<?php

namespace Modules\Core\Helpers;

class ConfigHelper
{
    public static function cssUrl($file)
    {
        return url('/').'/cwa_css/core/' . str_replace('/', '&', $file);
    }

    public static function jsUrl($file)
    {
        return url('/').'/cwa_js/core/' . $file;
    }

    public static function imgUrl($file)
    {
        return url('/').'/cwa_img/core/' . $file;
    }

    public static function pluginsUrl($file)
    {
        return url('/').'/cwa_plugin/core/' . str_replace('/', '&', $file);
    }
}
