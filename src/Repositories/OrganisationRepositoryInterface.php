<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\OrganisationCreateRequest;
use Vng\DennisCore\Http\Requests\OrganisationUpdateRequest;
use Vng\DennisCore\Models\Organisation;

interface OrganisationRepositoryInterface
{
    public function create(OrganisationCreateRequest $request): Organisation;
    public function update(Organisation $organisation, OrganisationUpdateRequest $request): Organisation;

    public function attachManagers(Organisation $organisation, string|array $managerIds): Organisation;
    public function detachManagers(Organisation $organisation, string|array $managerIds): Organisation;

    public function attachContacts(Organisation $organisation, string|array $contactIds): Organisation;
    public function detachContacts(Organisation $organisation, string|array $contactIds): Organisation;
}
