<?php

namespace Vng\DennisCore\Commands\Geo;

use Vng\DennisCore\Services\GeoData\BasicRegionModel;
use Vng\DennisCore\Services\GeoData\RegionDataService;
use Vng\DennisCore\Services\GeoData\RegionService;
use Illuminate\Console\Command;

class RegionsCreateDataFromSource extends Command
{
    protected $signature = 'geo:regions-create {--d|download}';
    protected $description = 'Create region database entries from the data source file';

    public function handle(): int
    {
        $this->getOutput()->writeln('create region data from source data..');
        $this->output->writeln('');

        if ($this->option('download')) {
            $regionData = RegionDataService::loadOrCreateSourceData();
        } else {
            $regionData = RegionDataService::loadSourceData();
        }

        $sourceData = RegionDataService::createBasicGeoCollectionFromData($regionData);
        $sourceData->each(function (BasicRegionModel $regionModel) {
            $this->output->write('.');
            RegionService::createRegion($regionModel);
        });

        $this->output->writeln('');
        $this->getOutput()->writeln('create region data from source data finished!');
        $this->output->writeln('');
        $this->output->writeln('');
        return 0;
    }
}
