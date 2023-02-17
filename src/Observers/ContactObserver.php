<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Organisation;

class ContactObserver
{
    public function created(Contact $contact): void
    {
        $this->syncConnectedElasticResources($contact);
    }

    public function updated(Contact $contact): void
    {
        $this->syncConnectedElasticResources($contact);
    }

    public function deleted(Contact $contact): void
    {
        $this->syncConnectedElasticResources($contact);
    }

    public function restored(Contact $contact): void
    {
        $this->syncConnectedElasticResources($contact);
    }

    private function syncConnectedElasticResources(Contact $contact): void
    {
        $contact->instruments->each(
            fn($instrument) => ElasticRelatedResourceChanged::dispatch($instrument, $contact)
        );
        $contact->providers->each(
            fn($provider) => ElasticRelatedResourceChanged::dispatch($provider, $contact)
        );
        $contact->organisations->each(
            function (Organisation $organisation) use ($contact) {
                if ($organisation->localParty) {
                    ElasticRelatedResourceChanged::dispatch($organisation->localParty, $contact);
                }
                if ($organisation->regionalParty) {
                    ElasticRelatedResourceChanged::dispatch($organisation->regionalParty, $contact);
                }
                if ($organisation->nationalParty) {
                    ElasticRelatedResourceChanged::dispatch($organisation->nationalParty, $contact);
                }
                if ($organisation->partnership) {
                    ElasticRelatedResourceChanged::dispatch($organisation->partnership, $contact);
                }
            }
        );

        /** @deprecated  */
        $contact->regions->each(
            fn($region) => ElasticRelatedResourceChanged::dispatch($region, $contact)
        );
    }
}
