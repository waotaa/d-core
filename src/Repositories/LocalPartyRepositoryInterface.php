<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\LocalPartyCreateRequest;
use Vng\DennisCore\Http\Requests\LocalPartyUpdateRequest;
use Vng\DennisCore\Models\LocalParty;

interface LocalPartyRepositoryInterface extends BaseRepositoryInterface, SoftDeletableRepositoryInterface
{
    public function create(LocalPartyCreateRequest $request): LocalParty;
    public function update(LocalParty $localParty, LocalPartyUpdateRequest $request): LocalParty;
}
