<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Models\Link;

class LinkObserver
{
    public function created(Link $link): void
    {
        $this->syncConnectedElasticResources($link);
    }

    public function updated(Link $link): void
    {
        $this->syncConnectedElasticResources($link);
    }

    public function deleted(Link $link): void
    {
        $this->syncConnectedElasticResources($link);
    }

    public function restored(Link $link): void
    {
        $this->syncConnectedElasticResources($link);
    }

    private function syncConnectedElasticResources(Link $link): void
    {
        if (!is_null($link->instrument)) {
            ElasticRelatedResourceChanged::dispatch($link->instrument, $link);
        }
    }
}
