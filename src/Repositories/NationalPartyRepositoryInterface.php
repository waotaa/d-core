<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\NationalPartyCreateRequest;
use Vng\DennisCore\Http\Requests\NationalPartyUpdateRequest;
use Vng\DennisCore\Models\NationalParty;

interface NationalPartyRepositoryInterface extends BaseRepositoryInterface, SoftDeletableRepositoryInterface
{
    public function create(NationalPartyCreateRequest $request): NationalParty;
    public function update(NationalParty $nationalParty, NationalPartyUpdateRequest $request): NationalParty;
}
