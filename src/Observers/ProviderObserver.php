<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Models\Provider;

class ProviderObserver
{
    public function created(Provider $provider): void
    {
        $this->syncConnectedElasticResources($provider);
    }

    public function updated(Provider $provider): void
    {
        $this->syncConnectedElasticResources($provider);
    }

    public function deleted(Provider $provider): void
    {
        $this->syncConnectedElasticResources($provider);
    }

    public function restored(Provider $provider): void
    {
        $this->syncConnectedElasticResources($provider);
    }

    private function syncConnectedElasticResources(Provider $provider): void
    {
        $provider->instruments->each(
            function ($instrument) use ($provider) {
                ElasticRelatedResourceChanged::dispatch($instrument, $provider);
            }
        );
    }
}
