<?php

namespace Vng\DennisCore\Commands\Elastic;

use Vng\DennisCore\Jobs\RemoveResourceFromElasticJob;
use Vng\DennisCore\Jobs\SyncSearchableModelToElasticJob;
use Vng\DennisCore\Models\Region;
use Illuminate\Console\Command;
use Vng\DennisCore\Models\RegionPage;

class SyncRegionPages extends Command
{
    protected $signature = 'elastic:sync-region-pages {--f|fresh}';
    protected $description = 'Sync all region pages to ES';

    public function handle(): int
    {
        $this->getOutput()->writeln('syncing region pages');
        $this->getOutput()->writeln('used index-prefix: ' . config('elastic.prefix'));

        if ($this->option('fresh')) {
            $this->call('elastic:delete-index', ['index' => 'region-pages', '--force' => true]);
        }

        $this->getOutput()->writeln('');
        foreach (RegionPage::all() as $regionPage) {
            $this->getOutput()->write('.');
            dispatch(new SyncSearchableModelToElasticJob($regionPage));
        }

        foreach (RegionPage::onlyTrashed()->get() as $regionPage) {
            dispatch(new RemoveResourceFromElasticJob($regionPage->getSearchIndex(), $regionPage->getSearchId()));
        }

        $this->getOutput()->writeln('');
        $this->getOutput()->writeln('');
        return 0;
    }
}
