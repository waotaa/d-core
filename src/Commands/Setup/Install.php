<?php

namespace Vng\DennisCore\Commands\Setup;

use Illuminate\Console\Command;

class Install extends Command
{
    protected $signature = 'dennis-core:install {--n|no-interaction}';
    protected $description = 'Installs the package';

    public function handle(): int
    {
        $this->info("\n[ Installing dennis core ]\n");

        $this->publishPackage();

        $this->call(Setup::class, [
            '--no-interaction' => $this->option('no-interaction'),
        ]);

        $this->info("\n[ Installling dennis core ] - finished!\n");
        return 0;
    }

    private function publishPackage()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Vng\DennisCore\Providers\DennisServiceProvider',
            '--force' => true,
        ]);
    }
}
