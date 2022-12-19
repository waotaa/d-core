<?php

namespace Vng\DennisCore\Commands\Geo;

use Vng\DennisCore\Services\GeoData\RegionDataService;
use Vng\DennisCore\Services\GeoData\TownshipDataService;
use Illuminate\Console\Command;

class GeoSourceGenerate extends Command
{
    protected $signature = 'geo:generate-source';
    protected $description = 'Generate region and township data files from different sources';

    public function handle(): int
    {
        $this->getOutput()->writeln('generating area data...');
        $this->warn('This will create new source files for townships and regions');
        if ($this->confirm('Are you sure')) {
            RegionDataService::createSourceData();
            TownshipDataService::createSourceData();
        }
        $this->getOutput()->writeln('generating area data finished!');
        return 0;
    }
}
