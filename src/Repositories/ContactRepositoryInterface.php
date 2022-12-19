<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\ContactCreateRequest;
use Vng\DennisCore\Http\Requests\ContactUpdateRequest;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Instrument;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContactCreateRequest $request): Contact;
    public function update(Contact $download, ContactUpdateRequest $request): Contact;

    public function attachInstruments(Contact $contact, string|array $instrumentIds, ?string $type = null): Contact;
    public function detachInstruments(Contact $contact, string|array $instrumentIds): Contact;

    public function attachProviders(Contact $contact, string|array $providerIds, ?string $type = null): Contact;
    public function detachProviders(Contact $contact, string|array $providerIds): Contact;
}