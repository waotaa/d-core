<?php

namespace Vng\DennisCore\Commands\Elastic;

use Illuminate\Console\Command;

class SyncAll extends Command
{
    protected $signature = 'elastic:sync-all {--f|fresh}';
    protected $description = 'Sync all searchable data to ES';

    public function handle(): int
    {
        $this->getOutput()->writeln('syncing...');

        $this->output->writeln('used elastic instance: ' . config('elastic.instances.public.cloud_id'));
        $this->output->writeln('used elastic username: ' . config('elastic.instances.public.username'));

        $this->call('elastic:sync-instruments', ['--fresh' => $this->option('fresh')]);
        $this->call('elastic:sync-providers', ['--fresh' => $this->option('fresh')]);
        $this->call('elastic:sync-regions', ['--fresh' => $this->option('fresh')]);
        $this->call('elastic:sync-region-pages', ['--fresh' => $this->option('fresh')]);
        $this->call('elastic:sync-tiles', ['--fresh' => $this->option('fresh')]);
        $this->call('elastic:sync-townships', ['--fresh' => $this->option('fresh')]);

        return 0;
    }
}
