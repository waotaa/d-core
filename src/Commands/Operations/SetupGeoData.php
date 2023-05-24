<?php

namespace Vng\DennisCore\Commands\Operations;

use Illuminate\Console\Command;
use Vng\DennisCore\Commands\Geo\RegionsAssign;
use Vng\DennisCore\Commands\Geo\RegionsCreateDataFromSource;
use Vng\DennisCore\Commands\Geo\TownshipsCreateDataFromSource;

class SetupGeoData extends Command
{
    protected $signature = 'dennis:setup-geo {--d|download}';
    protected $description = 'Run the geo setup commands';

    public function handle(): int
    {
        $this->call(TownshipsCreateDataFromSource::class, [
            '--download' => $this->option('download'),
        ]);
        $this->call(RegionsCreateDataFromSource::class, [
            '--download' => $this->option('download'),
        ]);
        $this->call(RegionsAssign::class);
//        $this->call('elastic:sync-regions', [
//            '--fresh' => true,
//        ]);
        return 0;
    }
}
