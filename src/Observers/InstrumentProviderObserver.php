<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\InstrumentAttachedEvent;
use Vng\DennisCore\Events\InstrumentDetachedEvent;
use Vng\DennisCore\Events\ProviderAttachedEvent;
use Vng\DennisCore\Events\ProviderDetachedEvent;
use Vng\DennisCore\Models\InstrumentProvider;

class InstrumentProviderObserver
{
    public function created(InstrumentProvider $instrumentProvider): void
    {
        $this->attachConnectedElasticResources($instrumentProvider);
    }

    public function updated(InstrumentProvider $instrumentProvider): void
    {
        $this->attachConnectedElasticResources($instrumentProvider);
    }

    public function deleted(InstrumentProvider $instrumentProvider): void
    {
        $this->detachConnectedElasticResources($instrumentProvider);
    }

    public function restored(InstrumentProvider $instrumentProvider): void
    {
        $this->attachConnectedElasticResources($instrumentProvider);
    }

    private function attachConnectedElasticResources(InstrumentProvider $instrumentProvider): void
    {
        InstrumentAttachedEvent::dispatch($instrumentProvider);
        ProviderAttachedEvent::dispatch($instrumentProvider);
    }

    private function detachConnectedElasticResources(InstrumentProvider $instrumentProvider): void
    {
        InstrumentDetachedEvent::dispatch($instrumentProvider);
        ProviderDetachedEvent::dispatch($instrumentProvider);
    }
}
