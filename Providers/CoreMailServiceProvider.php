<?php

namespace Modules\Core\Providers;

use Illuminate\Mail\MailServiceProvider;
use Modules\Core\Config\CoreTransportManager;

class CoreMailServiceProvider extends MailServiceProvider
{
    protected function registerSwiftTransport()
    {
        $this->app['swift.transport'] = $this->app->share(function ($app) {
            return new CoreTransportManager($app);
        });
    }
}
