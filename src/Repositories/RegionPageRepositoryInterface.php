<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\RegionPageCreateRequest;
use Vng\DennisCore\Http\Requests\RegionPageUpdateRequest;
use Vng\DennisCore\Models\RegionPage;

interface RegionPageRepositoryInterface extends BaseRepositoryInterface, SoftDeletableRepositoryInterface
{
    public function create(RegionPageCreateRequest $request): RegionPage;
    public function update(RegionPage $regionPage, RegionPageUpdateRequest $request): RegionPage;

    public function attachContacts(RegionPage $regionPage, string|array $contactIds): RegionPage;
    public function detachContacts(RegionPage $regionPage, string|array $contactIds): RegionPage;
}
