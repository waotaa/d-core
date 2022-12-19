<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\AgeGroupCreateRequest;
use Vng\DennisCore\Http\Requests\AgeGroupUpdateRequest;
use Vng\DennisCore\Models\AgeGroup;

interface AgeGroupRepositoryInterface extends BaseRepositoryInterface
{
    public function create(AgeGroupCreateRequest $request): AgeGroup;
    public function update(AgeGroup $ageGroup, AgeGroupUpdateRequest $request): AgeGroup;

    public function attachInstruments(AgeGroup $ageGroup, string|array $instrumentIds): AgeGroup;
    public function detachInstruments(AgeGroup $ageGroup, string|array $instrumentIds): AgeGroup;
}
