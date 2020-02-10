<?php

namespace Modules\Core\Providers;

use Auth;
use Modules\Core\User;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Auth\EloquentUserCustomProvider;

class CustomAuthProvider extends ServiceProvider
{
    /**
    * Bootstrap the application services.
    *
    * @return void
    */
    public function boot()
    {
        $this->app['auth']->extend('eloquent_custom', function () {
            return new EloquentUserCustomProvider($this->app['config']['auth.model']);
        });
    }

    /**
    * Register the application services.
    *
    * @return void
    */
    public function register()
    {
    }
}
