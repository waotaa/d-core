<?php

namespace Vng\DennisCore\Observers;

use Illuminate\Support\Facades\Log;
use Vng\DennisCore\Events\ContactAttachedEvent;
use Vng\DennisCore\Events\ContactDetachedEvent;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Contactables;

class ContactablesObserver
{
    public function created(Contactables $contactables): void
    {
        $this->attachConnectedElasticResources($contactables);
    }

    public function updated(Contactables $contactables): void
    {
        $this->attachConnectedElasticResources($contactables);
    }

    public function deleted(Contactables $contactables): void
    {
        $pivotParent = $contactables->pivotParent;
        if (get_class($pivotParent) !== Contact::class) {
            $contactable = $pivotParent;
        } else {
            $contactable = $contactables->getContactableEntity();
        }

        Log::debug('detached contact', [
            'contactable' => $contactable
        ]);

        ContactDetachedEvent::dispatch($contactables->contact, $contactable);
    }

    public function restored(Contactables $contactables): void
    {
        $this->attachConnectedElasticResources($contactables);
    }

    private function attachConnectedElasticResources(Contactables $contactables): void
    {
        ContactAttachedEvent::dispatch($contactables->contact, $contactables->contactable);
    }
}
