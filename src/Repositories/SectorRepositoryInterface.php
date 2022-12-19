<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\SectorCreateRequest;
use Vng\DennisCore\Http\Requests\SectorUpdateRequest;
use Vng\DennisCore\Models\Sector;

interface SectorRepositoryInterface extends BaseRepositoryInterface
{
    public function create(SectorCreateRequest $request): Sector;
    public function update(Sector $sector, SectorUpdateRequest $request): Sector;

    public function attachInstruments(Sector $sector, string|array $instrumentIds): Sector;
    public function detachInstruments(Sector $sector, string|array $instrumentIds): Sector;
}
