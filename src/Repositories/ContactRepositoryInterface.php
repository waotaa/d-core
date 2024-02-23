<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\ContactCreateRequest;
use Vng\DennisCore\Http\Requests\ContactUpdateRequest;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Instrument;

interface ContactRepositoryInterface extends OwnedEntityRepositoryInterface
{
    public function create(ContactCreateRequest $request): Contact;
    public function update(Contact $download, ContactUpdateRequest $request): Contact;

    public function attachInstruments(Contact $contact, string|array $instrumentIds, ?string $type = null, ?string $label = null): Contact;
    public function detachInstruments(Contact $contact, string|array $instrumentIds): Contact;

    public function attachProviders(Contact $contact, string|array $providerIds, ?string $type = null, ?string $label = null): Contact;
    public function detachProviders(Contact $contact, string|array $providerIds): Contact;

    public function attachRegionPages(Contact $contact, string|array $regionPageIds, ?string $type = null, ?string $label = null): Contact;
    public function detachRegionPages(Contact $contact, string|array $regionPageIds): Contact;
}
