<?php

namespace Vng\DennisCore\Commands\Elastic;

use Vng\DennisCore\Jobs\RemoveResourceFromElasticJob;
use Vng\DennisCore\Jobs\SyncSearchableModelToElasticJob;
use Vng\DennisCore\Models\Instrument;
use Illuminate\Console\Command;
use Vng\DennisCore\Models\SyncAttempt;

class SyncInstruments extends Command
{
    protected $signature = 'elastic:sync-instruments {--f|fresh}';
    protected $description = 'Sync all instruments to ES';

    public function handle(): int
    {
        $this->output->writeln('syncing instruments...');
        $this->output->writeln('used index-prefix: ' . config('elastic.prefix'));

        if ($this->option('fresh')) {
            $this->call(DeleteIndex::class, ['index' => 'instruments', '--force' => true]);
        }

        $this->output->writeln('');
        foreach (Instrument::all() as $instrument) {
            $this->output->write('.');
//            $this->getOutput()->write('- ' . $instrument->name);

            $attempt = new SyncAttempt();
            $attempt->action = 'sync';
            $attempt->resource()->associate($instrument);
            $attempt->save();

            dispatch(new SyncSearchableModelToElasticJob($instrument, $attempt));
        }

        foreach (Instrument::onlyTrashed()->get() as $instrument) {
            dispatch(new RemoveResourceFromElasticJob($instrument->getSearchIndex(), $instrument->getSearchId()));
        }

        $this->output->newLine(2);
        $this->output->writeln('syncing instruments finished!');
        return 0;
    }
}
