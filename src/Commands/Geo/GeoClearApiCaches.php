<?php

namespace Vng\DennisCore\Commands\Geo;

use Illuminate\Console\Command;
use Vng\DennisCore\Services\GeoApi\CbsOpenDataApiService;

class GeoClearApiCaches extends Command
{
    protected $signature = 'geo:clear-api-cache';
    protected $description = 'Clear saved api results';

    public function handle(): int
    {
        $this->getOutput()->writeln('clearing api caches...');

        CbsOpenDataApiService::clearCache();
        CbsOpenDataApiService::clearCache(true);

        $this->getOutput()->writeln('clearing api caches finished!');
        return 0;
    }
}
