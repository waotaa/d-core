<?php

namespace Vng\DennisCore\Commands\Elastic;

use Vng\DennisCore\Jobs\RemoveResourceFromElasticJob;
use Vng\DennisCore\Jobs\SyncSearchableModelToElasticJob;
use Vng\DennisCore\Models\SyncAttempt;
use Vng\DennisCore\Models\Township;
use Illuminate\Console\Command;

class SyncTownships extends Command
{
    protected $signature = 'elastic:sync-townships {--f|fresh}';
    protected $description = 'Sync townships to ES';

    public function handle(): int
    {
        $this->getOutput()->writeln('syncing townships');
        $this->getOutput()->writeln('used index-prefix: ' . config('elastic.prefix'));

        if ($this->option('fresh')) {
            $this->call('elastic:delete-index', ['index' => 'townships', '--force' => true]);
        }

        $this->output->writeln('');
        foreach (Township::all() as $township) {
            $this->getOutput()->write('.');
//            $this->getOutput()->write('- ' . $township->name);

            $attempt = new SyncAttempt();
            $attempt->action = 'sync';
            $attempt->resource()->associate($township);
            $attempt->save();

            dispatch(new SyncSearchableModelToElasticJob($township, $attempt));
        }

        foreach (Township::onlyTrashed()->get() as $township) {
            dispatch(new RemoveResourceFromElasticJob($township->getSearchIndex(), $township->getSearchId()));
        }

        $this->output->writeln('');
        $this->output->writeln('');
        return 0;
    }
}
