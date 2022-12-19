<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Models\Location;

class LocationObserver
{
    public function created(Location $location): void
    {
        $this->syncConnectedElasticResources($location);
    }

    public function updated(Location $location): void
    {
        $this->syncConnectedElasticResources($location);
    }

    public function deleted(Location $location): void
    {
        $this->syncConnectedElasticResources($location);
    }

    public function restored(Location $location): void
    {
        $this->syncConnectedElasticResources($location);
    }

    private function syncConnectedElasticResources(Location $location): void
    {
        if (!is_null($location->instrument)) {
            ElasticRelatedResourceChanged::dispatch($location->instrument, $location);
        }
    }
}
