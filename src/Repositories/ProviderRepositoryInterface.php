<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\ProviderCreateRequest;
use Vng\DennisCore\Http\Requests\ProviderUpdateRequest;
use Vng\DennisCore\Models\Provider;

interface ProviderRepositoryInterface extends OwnedEntityRepositoryInterface, SoftDeletableRepositoryInterface
{
    public function create(ProviderCreateRequest $request): Provider;
    public function update(Provider $provider, ProviderUpdateRequest $request): Provider;

    public function attachContacts(Provider $provider, string|array $contactIds, ?string $type = null, ?string $label = null): Provider;
    public function detachContacts(Provider $provider, string|array $contactIds): Provider;
}
