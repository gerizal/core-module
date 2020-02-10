<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;

class Migrator implements SetupScript
{
    /**
     * @var array
     */
    protected $modules = [
        'Core',
        'Product',
        'Ads',
        'News',
        'Hook',
        'EmailPreference',
        'EmailHook',
        'Notification',
        'JVZoo'
    ];

    /**
     * Fire the install script
     * @param  Command $command
     * @return mixed
     */
    public function fire(Command $command)
    {
        if ($command->option('verbose')) {
            $command->blockMessage('Migrations', 'Starting the migrations ...', 'comment');
        }

        if ($command->option('verbose')) {
            $command->call('migrate');
        }

        foreach ($this->modules as $module) {
            if ($command->option('verbose')) {
                $command->call('module:migrate', ['module' => $module]);
                continue;
            }

            shell_exec('php artisan module:migrate '.$module);
        }

        shell_exec('php artisan migrate');
    }
}
