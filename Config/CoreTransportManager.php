<?php

namespace Modules\Core\Config;

use Illuminate\Mail\TransportManager;
use Modules\Core\Helpers\SettingHelper;

class CoreTransportManager extends TransportManager
{
  /**
   * Create a new manager instance.
   *
   * @param  \Illuminate\Foundation\Application  $app
   * @return void
   */
    public function __construct($app)
    {
        $this->app                      = $app;
        $this->app['config']['mail']    = [
            'driver'        => SettingHelper::mail_driver(),
            'host'          => SettingHelper::mail_host(),
            'port'          => SettingHelper::mail_port(),
            'from'  => [
                'address'   => SettingHelper::mail_from_email(),
                'name'      => SettingHelper::mail_from_name()
            ],
            'encryption'    => SettingHelper::mail_encryption(),
            'username'      => SettingHelper::mail_username(),
            'password'      => SettingHelper::mail_password(),
            'sendmail'      => '/usr/sbin/sendmail -bs',
            'pretend'       => false
        ];
    }
}
