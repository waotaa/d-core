<?php

namespace Vng\DennisCore\Commands\Setup;

use Illuminate\Console\Command;
use Vng\DennisCore\Commands\Operations\SetupGeoData;

class Setup extends Command
{
    protected $signature = 'dennis-core:setup {--n|no-interaction} {--l|lean}';
    protected $description = 'Setup the core';

    public function handle(): int
    {
        $this->info("\n[ Setting up dennis core ]\n");

        $this->call('key:generate');

        $this->setupDatabase();
        if (!$this->option('lean')) {
            $this->setupUtilities();
        }

        $this->info("\n[ Setting up dennis core ] - finished!\n");
        return 0;
    }

    private function setupDatabase()
    {
        $this->call('migrate:fresh', ['--force' => true]);
        $this->call(SeedCharacteristics::class);
        $this->call(SetupAuthorizationMatrix::class);
    }

    private function setupUtilities()
    {
        $this->call(SetupGeoData::class);

        $this->call(CreateTestInstrument::class);
    }
}
