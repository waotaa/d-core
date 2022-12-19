<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\PartnershipCreateRequest;
use Vng\DennisCore\Http\Requests\PartnershipUpdateRequest;
use Vng\DennisCore\Models\Partnership;

interface PartnershipRepositoryInterface extends BaseRepositoryInterface, SoftDeletableRepositoryInterface
{
    public function create(PartnershipCreateRequest $request): Partnership;
    public function update(Partnership $partnership, PartnershipUpdateRequest $request): Partnership;

    public function attachTownships(Partnership $partnership, string|array $townshipIds): Partnership;
    public function detachTownships(Partnership $partnership, string|array $townshipIds): Partnership;
}
