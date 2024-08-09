<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ModelHelpers\InstrumentTrackerHelper;

class InstrumentObserver
{
    public function created(Instrument $instrument): void
    {
        $this->syncConnectedElasticResources($instrument);

        $user = request()->user();
        if ($user) {
            InstrumentTrackerHelper::createQuickTrackerForCreator($instrument, $user->manager);
        }
    }

    public function updated(Instrument $instrument): void
    {
        $this->syncConnectedElasticResources($instrument);

        $user = request()->user();
        if ($user) {
            InstrumentTrackerHelper::createQuickTrackerForAuthor($instrument, $user->manager);
        }
    }

    public function deleted(Instrument $instrument): void
    {
        $this->syncConnectedElasticResources($instrument);
    }

    public function restored(Instrument $instrument): void
    {
        $this->syncConnectedElasticResources($instrument);
    }

    private function syncConnectedElasticResources(Instrument $instrument): void
    {
        if ($instrument->provider) {
            ElasticRelatedResourceChanged::dispatch($instrument->provider, $instrument);
        }

//        deprecated
//        No more muliple providers on instrument
//        $instrument->providers->each(
//            fn($provider) => ElasticRelatedResourceChanged::dispatch($provider, $instrument)
//        );
    }
}
