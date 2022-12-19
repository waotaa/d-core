<?php

namespace Vng\DennisCore\Commands\Elastic;

use Vng\DennisCore\ElasticResources\Public\InstrumentResource;
use Vng\DennisCore\Jobs\RemoveResourceFromPublicElasticJob;
use Vng\DennisCore\Jobs\SyncResourceToPublicElasticJob;
use Illuminate\Console\Command;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ElasticSearch\ElasticPublicClientBuilder;

class SyncPublicInstruments extends Command
{
    protected $signature = 'elastic:sync-public-instruments';
    protected $description = 'Sync public instruments resources to public ES instance';

    public function handle(): int
    {
        $this->getOutput()->writeln('syncing public instruments');

        if (!ElasticPublicClientBuilder::hasSettings()){
            $this->output->writeln('public instance settings missing');
            return 0;
        }

        $this->output->writeln('');
        foreach (Instrument::all() as $instrument) {
            $this->getOutput()->write('.');
            dispatch(new SyncResourceToPublicElasticJob(
                $instrument,
                'instruments',
                InstrumentResource::class,
            ));
        }

        foreach (Instrument::onlyTrashed()->get() as $instrument) {
            dispatch(new RemoveResourceFromPublicElasticJob(
                'instruments',
                $instrument->getSearchId()
            ));
        }

        $this->output->writeln('');
        $this->output->writeln('');
        return 0;
    }
}
