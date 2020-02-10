<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\Installer;
use Modules\Core\Console\Installers\Traits\BlockMessage;
use Modules\Core\Console\Installers\Traits\SectionMessage;
use Symfony\Component\Console\Input\InputOption;

class SeedCommand extends Command
{
    use BlockMessage, SectionMessage;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name         = 'cwa:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description  = 'Database seeding Core Web App Platform';

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
        $success = $this->installer->stack([
            \Modules\Core\Console\Installers\Scripts\Seeder::class,
        ])->install($this);

        if ($success) {
            $this->info(
                sprintf(
                    'Database seeding success! You can now login using email [%s] and password [secret] at %s.',
                    'normaluser@stickyviral.com',
                    '/auth/login'
                )
            );
        }
    }
}
