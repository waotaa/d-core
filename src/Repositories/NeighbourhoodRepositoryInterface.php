<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\NeighbourhoodCreateRequest;
use Vng\DennisCore\Http\Requests\NeighbourhoodUpdateRequest;
use Vng\DennisCore\Models\Neighbourhood;

interface NeighbourhoodRepositoryInterface extends BaseRepositoryInterface
{
    public function create(NeighbourhoodCreateRequest $request): Neighbourhood;
    public function update(Neighbourhood $neighbourhood, NeighbourhoodUpdateRequest $request): Neighbourhood;
}
