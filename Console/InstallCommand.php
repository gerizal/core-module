<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\Installer;
use Modules\Core\Console\Installers\Traits\BlockMessage;
use Modules\Core\Console\Installers\Traits\SectionMessage;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    use BlockMessage, SectionMessage;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name         = 'cwa:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description  = 'Install Core Web App Platform';

    /**
     * @var Installer
     */
    private $installer;

    /**
     * Create a new command instance.
     *
     * @param Installer $installer
     * @internal param Filesystem $finder
     * @internal param Application $app
     * @internal param Composer $composer
     */
    public function __construct(Installer $installer)
    {
        parent::__construct();
        $this->getLaravel()['env']  = 'local';
        $this->installer            = $installer;
    }

    /**
     * Execute the actions
     *
     * @return mixed
     */
    public function fire()
    {
        $this->blockMessage('Welcome!', 'Starting the installation process...', 'comment');

        // Remove the existing .env file
        if (file_exists('.env')) {
            unlink('.env');
        }

        $success = $this->installer->stack([
            \Modules\Core\Console\Installers\Scripts\ProtectInstaller::class,
            \Modules\Core\Console\Installers\Scripts\ConfigureDatabase::class,
            \Modules\Core\Console\Installers\Scripts\Migrator::class,
            \Modules\Core\Console\Installers\Scripts\SetAppKey::class,
            \Modules\Core\Console\Installers\Scripts\Seeder::class,
        ])->install($this);

        if ($success) {
            $this->info(
                sprintf(
                    'Platform ready! You can now login using email [%s] and password [secret] at %s.',
                    'admin@stickyviral.com',
                    '/auth/login'
                )
            );
        }
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force the installation, even if already installed']
        ];
    }
}
