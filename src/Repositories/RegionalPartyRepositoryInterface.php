<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\RegionalPartyCreateRequest;
use Vng\DennisCore\Http\Requests\RegionalPartyUpdateRequest;
use Vng\DennisCore\Models\RegionalParty;

interface RegionalPartyRepositoryInterface extends BaseRepositoryInterface, SoftDeletableRepositoryInterface
{
    public function create(RegionalPartyCreateRequest $request): RegionalParty;
    public function update(RegionalParty $regionalParty, RegionalPartyUpdateRequest $request): RegionalParty;
}
