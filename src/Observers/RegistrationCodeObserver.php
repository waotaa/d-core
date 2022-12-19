<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Models\RegistrationCode;

class RegistrationCodeObserver
{
    public function created(RegistrationCode $registrationCode): void
    {
        $this->syncConnectedElasticResources($registrationCode);
    }

    public function updated(RegistrationCode $registrationCode): void
    {
        $this->syncConnectedElasticResources($registrationCode);
    }

    public function deleted(RegistrationCode $registrationCode): void
    {
        $this->syncConnectedElasticResources($registrationCode);
    }

    public function restored(RegistrationCode $registrationCode): void
    {
        $this->syncConnectedElasticResources($registrationCode);
    }

    private function syncConnectedElasticResources(RegistrationCode $registrationCode): void
    {
        if (!is_null($registrationCode->instrument)) {
            ElasticRelatedResourceChanged::dispatch($registrationCode->instrument, $registrationCode);
        }
    }
}
